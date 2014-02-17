<?php
class databaseConnection
{
    protected $preparedStatements;

    protected $missingParamAsString;
    protected $missingParam;
    protected $tooManyParamAsString;
    protected $tooManyParam;
    protected $bindedParameters;

    protected $dbh; // Database Handler
    protected $statementID = -1;

    public function databaseConnection()
	{
		require("db.config.php");

		try
		{
			$this->dbh = new PDO('mysql:host='.$DBConfig['server'].';dbname='.$DBConfig['database'], $DBConfig['user'], $DBConfig['pw']);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->beginTransaction();
		}
		catch(PDOException $e)
		{
			trigger_error("No database connection.", E_USER_ERROR);
		}
	}

    /*
     * Prepare a SQL statement for later execution
     *
     * @param String $sql  The SQL statement with place holders like ':name' or ':street'
     * @param String $type read/write - The type of the SQL statement. If it is a SELECT set it to read if it is an UPDATE or INSERT set it to write
     */
    protected function prepareSQL($sql, $type)
	{
        if($type != "read" && $type != "write")
        {
            trigger_error("SQL statement type must be 'write' or 'read' but it was '" . $type . "'", E_USER_ERROR);
            return;
        }

		$this->preparedStatements[] = array("sql" => $sql,
                                            "preparedSQL" => $this->dbh->prepare($sql),
                                             "type" => $type);

        $this->statementID++;
	}

    /*
     * Replace all placeholders in the actual sql string with de values in the array
     *
     * @param String[] $values Associative-Array with all values or single value
     * @param String   $param  parameter name for assignment wen only one value as string is given
     */
    protected function bindParam($values, $param = false)
    {
        if(is_array($values))
        {
            foreach($values as $key => $value)
            {
                $this->preparedStatements[$this->statementID]['preparedSQL']->bindParam($key, $values[$key]);
                $this->bindedParameters[$this->statementID][$key] = $values[$key];
            }
        }
        else
        {
            if($param)
            {
                // do magic
                $this->preparedStatements[$this->statementID]['preparedSQL']->bindParam($param, $values);
                $this->bindedParameters[$this->statementID][$param] = $values;
            }
            else
            {
                 trigger_error("You need to define a parameter name to set the value", E_USER_ERROR);
            }
        }
    }


    /**
     * Execute the last prepared SQL statement and return result array or last inserted ID
     *
     * @return String[] If it was a select statement, it returns a assoc array with the results
     * @return String   If it was a insert or update statement, it will return the last inserted ID
     */
    protected function execute()
	{
        $allParametersAreSet = $this->checkIfAllParametersAreSet();

        if($allParametersAreSet === true)
        {
            try
            {
                $this->preparedStatements[$this->statementID]['preparedSQL']->execute();
                //trigger_error("Successfully executed the following SQL statement: <br/>" . $this->preparedStatements[$this->statementID]['sql'], E_USER_NOTICE);
            }
            catch(PDOException $e)
            {
                //trigger_error($e->getMessage(), E_USER_ERROR);
                trigger_error($e->getMessage(), E_USER_NOTICE);
                trigger_error($this->preparedStatements[$this->statementID]['sql'], E_USER_NOTICE);
                $this->preparedStatements[$this->statementID]['type'] = FALSE;
            }

            $this->preparedStatements[$this->statementID]['lastInsertedID'] = $this->dbh->lastInsertId();
        }
        else
        {
            if(count($this->missingParam[$this->statementID]) > 0)
            {
                trigger_error("You tried to execute an SQL statement ('".$this->preparedStatements[$this->statementID]['sql']."') but not all parameters where set, missing parameters are: " . $this->missingParamAsString[$this->statementID], E_USER_ERROR);
            }

            if(count($this->tooManyParam[$this->statementID]) > 0)
            {
                trigger_error("You tried to execute an SQL statement ('".$this->preparedStatements[$this->statementID]['sql']."') but there are to many parameter set: " . $this->tooManyParamAsString[$this->statementID], E_USER_ERROR);
            }

        }

        switch($this->preparedStatements[$this->statementID]['type'])
        {
            case "write":
                try
                {
                    $this->dbh->commit();
                }
                catch(PDOException $e)
                {
                    trigger_error($e->getMessage(), E_USER_NOTICE);
                }
                return $this->preparedStatements[$this->statementID]['lastInsertedID'];
                break;
            case "read":
                return $this->preparedStatements[$this->statementID]['preparedSQL']->fetchALL();
                break;
            default:
                try
                {
                    $this->dbh->rollback();
                }
                catch(PDOException $e)
                {
                    trigger_error($e->getMessage(), E_USER_NOTICE);
                }
                return false;
                break;
        }
	}

    protected function checkIfAllParametersAreSet()
    {
        // TODO insert code here! check out PDOStatement::debugDumpParams() for help (?)
        // TODO check if there are to many parameters are set

        preg_match_all("/:[a-zA-Z]*/", $this->preparedStatements[$this->statementID]['sql'], $neededParameters);

        if(count($neededParameters[0]) > 0)
        {
            foreach($neededParameters[0] as $value)
            {
                $neededParametersAsKeys[$value] = "";
            }

            if(count($neededParameters[0]) < count($this->bindedParameters[$this->statementID]))
            {
                $this->missingParam[$this->statementID] = array_diff_key($this->bindedParameters[$this->statementID], $neededParametersAsKeys);
                $this->missingParamAsString[$this->statementID] = implode(",", array_keys($this->missingParam[$this->statementID]));
                if(count($this->missingParam[$this->statementID]) > 0)
                {
                    return false;
                }
            }
            else
            {
                $this->tooManyParam[$this->statementID] = array_diff_key($neededParametersAsKeys, $this->bindedParameters[$this->statementID]);
                $this->tooManyParamAsString[$this->statementID] = implode(",", array_keys($this->tooManyParam[$this->statementID]));
                if(count($this->tooManyParam[$this->statementID]) > 0)
                {
                    return false;
                }
            }
        }
        return true;
    }

    protected function changeBoolToInt($dataArray)
    {
        foreach($dataArray as $key => $value)
        {
            if($value === true){
                $dataArray[$key] = 1;
            }elseif($value === false || $value === null){ // in memory to flo
                $dataArray[$key] = 0;
            }
        }

        return $dataArray;
    }
}
?>
