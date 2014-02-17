<?php
    require_once("class/db_soupStats.class.php");
    require_once("libs/raintpl/rain.tpl.class.php"); //include Rain TPL

    raintpl::$tpl_dir = "template/default/"; // template directory
    raintpl::$cache_dir = "tmp/"; // cache directory

    $db = new soupStatsDB();
    $user = $db->findUser($_POST['soupName']);
    $postsByType = $db->getPostsByUserGroupedByType($user[0]['csoupid']);
    $postsByContentType = $db->getPostsByUserGroupedContentType($user[0]['csoupid']);

    $tpl = new raintpl(); //include Rain TPL
    $tpl->assign( "soupName",  $user[0]['cusername']); // assign an array

    $tpl->assign( "postCount", $postsByType[0]['cpostCount']); // assign variable
    $tpl->assign( "repostCount",  $postsByType[1]['cpostCount']); // assign an array

    $tpl->assign( "postTypeRegularCount", 0);
    $tpl->assign( "postTypeLinkCount", 0);
    $tpl->assign( "postTypeQuoteCount", 0);
    $tpl->assign( "postTypeImageCount", 0);
    $tpl->assign( "postTypeVideoCount", 0);
    $tpl->assign( "postTypeFileCount", 0);
    $tpl->assign( "postTypeReviewCount", 0);
    $tpl->assign( "postTypeEventCount", 0);
    $tpl->assign( "postTypeOthersCount", 0);


    foreach ($postsByContentType as $postContentType)
    {
        switch($postContentType['ccontenttype'])
        {
            case "REGULAR":
                $tpl->assign( "postTypeRegularCount", $postContentType['cpostCount']);
                break;
            case "LINK":
                $tpl->assign( "postTypeLinkCount", $postContentType['cpostCount']);
                break;
            case "QUOTE":
                $tpl->assign( "postTypeQuoteCount", $postContentType['cpostCount']);
                break;
            case "IMAGE":
                $tpl->assign( "postTypeImageCount", $postContentType['cpostCount']);
                break;
            case "VIDEO":
                $tpl->assign( "postTypeVideoCount", $postContentType['cpostCount']);
                break;
            case "FILE":
                $tpl->assign( "postTypeFileCount", $postContentType['cpostCount']);
                break;
            case "REVIEW":
                $tpl->assign( "postTypeReviewCount", $postContentType['cpostCount']);
                break;
            case "EVENT":
                $tpl->assign( "postTypeEventCount", $postContentType['cpostCount']);
                break;
            default:
                $tpl->assign( "postTypeOthersCount", $postContentType['cpostCount']);
                break;
        }
    }

    $tpl->draw( "stats" ); // draw the template
?>