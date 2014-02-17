<?php
require_once("db.class.php");

class soupDB extends databaseConnection
{
    public function addUser($soupID, $username)
    {
        $result = $this->findUser($soupID);

        if(!$result)
        {
            $sql = "insert into tusers (csoupid, cusername) values (:soupid, :username)";

            $paramValues = array(   ":username" => $username,
                                    ":soupid"   => $soupID
                                );

            parent::prepareSQL($sql, "write");
            parent::bindParam($paramValues);
            return parent::execute();
        }

        return $result;
    }

    public function findUser($user)
    {
        $sql = "select * from tusers where cusername = :username or csoupid = :soupid";
	
        $paramValues = array(   ":username"	=> $user,
                                ":soupid"	=> $user
                            );

        parent::prepareSQL($sql, "read");
        parent::bindParam($paramValues);
        return parent::execute();
    }

    public function insertPost($post)
    {
        $sql = "insert into tstatsposts (cuserid, cpost, cfromsoupname, cfromsoupid, cviasoupname, cviasoupid, crepostcounter, cdate, ctime, cposttype, ccontenttype, creaction, cimported) values (:cuserid, :cpost, :cfromsoupname, :cfromsoupid, :cviasoupname, :cviasoupid, :crepostcounter, :cdate, :ctime, :cposttype, :ccontenttype, :creaction, :cimported)";

        parent::prepareSQL($sql, "write");
        parent::bindParam($post);
        return parent::execute();
    }

    public function updateRepostCount($post)
    {
        $sql = "update tstatsposts set crepostcounter = :crepostcounter where cuserid = :cuserid and cpost = :cpost";

        $paramValues = array(   ":crepostcounter"	=> $post[":crepostcounter"],
                                ":cuserid"	        => $post[":cuserid"],
                                ":cpost"	        => $post[":cpost"]
                            );

        parent::prepareSQL($sql, "write");
        parent::bindParam($paramValues);
        return parent::execute();
    }
}
?>
