<?php
require_once("db.class.php");

class soupStatsDB extends databaseConnection
{
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

    public function getPostsByUserGroupedByType($soupID)
    {
        $sql = "select cposttype, sum(ccounthelp) as cpostCount from tstatsposts where cuserid = :soupid group by cposttype";

        $paramValues = array(   ":soupid"	=> $soupID
                            );

        parent::prepareSQL($sql, "read");
        parent::bindParam($paramValues);
        return parent::execute();
    }

    public function getPostsByUserGroupedContentType($soupID, $postType = false)
    {
        switch($postType)
        {
            case "post":
            $sql = "select ccontenttype, sum(ccounthelp) as cpostCount from tstatsposts where cuserid = :soupid and cposttype = 'POST' group by ccontenttype";
                break;
            case "repost":
            $sql = "select ccontenttype, sum(ccounthelp) as cpostCount from tstatsposts where cuserid = :soupid and cposttype = 'REPOST'  group by ccontenttype";
                break;
            default:
                $sql = "select ccontenttype, sum(ccounthelp) as cpostCount from tstatsposts where cuserid = :soupid group by ccontenttype";
                break;
        }
        
        $paramValues = array( ":soupid"	=> $soupID );

        parent::prepareSQL($sql, "read");
        parent::bindParam($paramValues);
        return parent::execute();
    }
    
    public function getTopPosts($soupID)
    {
        $sql = "select cpost, crepostcounter from tstatsposts where cuserid = :soupid and cposttype = 'POST' order by crepostcounter DESC limit 0,50";

        $paramValues = array(":soupid"	=> $soupID);

        parent::prepareSQL($sql, "read");
        parent::bindParam($paramValues);
        return parent::execute();
    }
    
    public function getTopFavs($soupID)
    {
        $sql = "select cfromsoupid, cfromsoupname, sum(ccounthelp) as ccount from tstatsposts where cuserid = :soupid and cposttype = 'REPOST' group by cfromsoupid order by ccount DESC limit 0,10";

        $paramValues = array(":soupid"	=> $soupID);

        parent::prepareSQL($sql, "read");
        parent::bindParam($paramValues);
        return parent::execute();
    }
    
    public function getTopReposter($soupID)
    {
        $sql = "select creposterid, crepostername, sum(ccounthelp) as cpostcount from tstatsreposts where csoupid = :soupid group by creposterid order by cpostcount desc limit 0,10";

        $paramValues = array(":soupid"	=> $soupID);

        parent::prepareSQL($sql, "read");
        parent::bindParam($paramValues);
        return parent::execute();
    }
}
?>
