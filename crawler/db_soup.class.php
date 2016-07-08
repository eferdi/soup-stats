<?php
require_once("db.class.php");

class soupDB extends databaseConnection
{
    public function addUser($soupID, $username, $soupAvatarUrl)
    {
        $result = $this->findUser($soupID);

        date_default_timezone_set('UTC');
        $lastcrawl = date("Y-m-d H:i:s");

        if(!$result)
        {
            $sql = "insert into tusers (csoupid, cusername, cavatar, clastcrawl) values (:soupid, :username, :avatar, :lastcrawl)";

            $paramValues = array(   ":username" => $username,
                                    ":soupid"   => $soupID,
                                    ":avatar"   => $soupAvatarUrl,
                                    ":lastcrawl"     => $lastcrawl
                                );

            parent::prepareSQL($sql, "write");
            parent::bindParam($paramValues);
            return parent::execute();
        }
        else
        {
            if($result[0]['cavatar'] != $soupAvatarUrl)
            {

                $sql = "update tusers set cavatar = :avatar, clastcrawl = :lastcrawl where csoupid = :soupid";

                $paramValues = array(   ":soupid"   => $soupID,
                                        ":avatar"   => $soupAvatarUrl,
                                        ":lastcrawl"     => $lastcrawl
                                    );

                parent::prepareSQL($sql, "write");
                parent::bindParam($paramValues);
                return parent::execute();
            }
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
        $sql =
            "insert into tstatsposts ".
                "(cuserid, cpost, cfromsoupname, cfromsoupid, cviasoupname, ".
                "cviasoupid, crepostcounter, cdate, ctime, cposttype, ".
                "ccontenttype, creaction, cimported) ".
                "values (:cuserid, :cpost, :cfromsoupname, :cfromsoupid, :cviasoupname, ".
                ":cviasoupid, :crepostcounter, :cdate, :ctime, :cposttype, ".
                ":ccontenttype, :creaction, :cimported)".
                "ON DUPLICATE KEY UPDATE ".
                "cuserid=VALUES(cuserid), cpost=VALUES(cpost), cfromsoupname=VALUES(cfromsoupname), cfromsoupid=VALUES(cfromsoupid), cviasoupname=VALUES(cviasoupname), ".
                "cviasoupid=VALUES(cviasoupid), crepostcounter=VALUES(crepostcounter), cdate=VALUES(cdate), ctime=VALUES(ctime), cposttype=VALUES(cposttype), ".
                "ccontenttype=VALUES(ccontenttype), creaction=VALUES(creaction), cimported=VALUES(cimported)";

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
    
    public function findReposter($soupID, $soupPost, $soupReposterID)
    {
        $sql = "select * from tstatsreposts where csoupid = :soupid and cpostid = :postid and creposterid = :reposterid";
	
        $paramValues = array(   ":soupid"	=> $soupID,
                                ":postid"	=> $soupPost,
                                ":reposterid"	=> $soupReposterID
                            );

        parent::prepareSQL($sql, "read");
        parent::bindParam($paramValues);
        return parent::execute();
    }
    
    public function addReposter($soupID, $soupPostID, $soupReposterID, $soupReposterName)
    {
        $result = $this->findReposter($soupID, $soupPostID, $soupReposterID);
        
        if(!$result)
        {
            $sql = "insert into tstatsreposts (csoupid, cpostid, creposterid, crepostername) values (:soupid, :postid, :reposterid, :repostername)";

            $paramValues = array(   ":soupid" => $soupID,
                                    ":postid"   => $soupPostID,
                                    ":reposterid"   => $soupReposterID,
                                    ":repostername"   => $soupReposterName
                                );

            parent::prepareSQL($sql, "write");
            parent::bindParam($paramValues);
            return parent::execute();
        }

        return $result;
    }

    public function updateSince($soupID, $since)
    {
        $sql = "update tusers set clastsince = :since where csoupid = :soupid";

        $paramValues = array( ":since"	=> $since,
                              ":soupid" => $soupID
        );

        parent::prepareSQL($sql, "write");
        parent::bindParam($paramValues);
        return parent::execute();
    }

    public function getLastCrawlPosition($soupID)
    {
        $sql = "select * from tusers where csoupid = :soupid";

        $paramValues = array( ":soupid"	=> $soupID );

        parent::prepareSQL($sql, "read");
        parent::bindParam($paramValues);
        $result = parent::execute();

        if(count($result) > 0 && $result[0]['clastsince'] != null && $result[0]['clastsince'] > 0)
        {
            return $result[0]['clastsince'];
        }

        return false;
    }
}
?>
