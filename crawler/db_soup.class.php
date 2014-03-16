<?php
require_once("db.class.php");

class soupDB extends databaseConnection
{
    public function addUser($soupID, $username, $soupAvatarUrl)
    {
        $result = $this->findUser($soupID);

        if(!$result)
        {
            $sql = "insert into tusers (csoupid, cusername, cavatar) values (:soupid, :username, :avatar)";

            $paramValues = array(   ":username" => $username,
                                    ":soupid"   => $soupID,
                                    ":avatar"   => $soupAvatarUrl
                                );

            parent::prepareSQL($sql, "write");
            parent::bindParam($paramValues);
            return parent::execute();
        }
        else
        {
            if($result[0]['cavatar'] != $soupAvatarUrl)
            {

                $sql = "update tusers set cavatar = :avatar where csoupid = :soupid";

                $paramValues = array(   ":soupid"   => $soupID,
                                        ":avatar"   => $soupAvatarUrl
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
}
?>
