<?php
    require_once("class/db_soupStats.class.php");
    require_once("libs/raintpl/rain.tpl.class.php"); //include Rain TPL

    raintpl::$tpl_dir = "template/minimal/"; // template directory
    raintpl::$cache_dir = "tmp/"; // cache directory

    $db = new soupStatsDB();
    $user = $db->findUser($_REQUEST['soup']);
    $postsByType = $db->getPostsByUserGroupedByType($user[0]['csoupid']);
    //$allPostsByContentType = $db->getPostsByUserGroupedContentType($user[0]['csoupid']);
    $postsByContentType = $db->getPostsByUserGroupedContentType($user[0]['csoupid'], "post");
    $repostsByContentType = $db->getPostsByUserGroupedContentType($user[0]['csoupid'], "repost");
    
    $topPosts = $db->getTopPosts($user[0]['csoupid']);
    $topReposter = $db->getTopReposter($user[0]['csoupid']);
    $topFavs = $db->getTopFavs($user[0]['csoupid']);

    $tpl = new raintpl(); //include Rain TPL
    $tpl->assign("user", $user[0]);
    $tpl->assign("soupName",  $user[0]['cusername']); // assign an array

    $tpl->assign("postCount", $postsByType[0]['cpostCount']); // assign variable
    $tpl->assign("repostCount",  $postsByType[1]['cpostCount']); // assign an array

    $tpl->assign("postTypeRegularCount", 0);
    $tpl->assign("postTypeLinkCount", 0);
    $tpl->assign("postTypeQuoteCount", 0);
    $tpl->assign("postTypeImageCount", 0);
    $tpl->assign("postTypeVideoCount", 0);
    $tpl->assign("postTypeFileCount", 0);
    $tpl->assign("postTypeReviewCount", 0);
    $tpl->assign("postTypeEventCount", 0);
    $tpl->assign("postTypeOthersCount", 0);
    
    $tpl->assign("repostTypeRegularCount", 0);
    $tpl->assign("repostTypeLinkCount", 0);
    $tpl->assign("repostTypeQuoteCount", 0);
    $tpl->assign("repostTypeImageCount", 0);
    $tpl->assign("repostTypeVideoCount", 0);
    $tpl->assign("repostTypeFileCount", 0);
    $tpl->assign("repostTypeReviewCount", 0);
    $tpl->assign("repostTypeEventCount", 0);
    $tpl->assign("repostTypeOthersCount", 0);


    foreach ($postsByContentType as $postContentType)
    {
        switch($postContentType['ccontenttype'])
        {
            case "REGULAR":
                $tpl->assign("postTypeRegularCount", $postContentType['cpostCount']);
                break;
            case "LINK":
                $tpl->assign("postTypeLinkCount", $postContentType['cpostCount']);
                break;
            case "QUOTE":
                $tpl->assign("postTypeQuoteCount", $postContentType['cpostCount']);
                break;
            case "IMAGE":
                $tpl->assign("postTypeImageCount", $postContentType['cpostCount']);
                break;
            case "VIDEO":
                $tpl->assign("postTypeVideoCount", $postContentType['cpostCount']);
                break;
            case "FILE":
                $tpl->assign("postTypeFileCount", $postContentType['cpostCount']);
                break;
            case "REVIEW":
                $tpl->assign("postTypeReviewCount", $postContentType['cpostCount']);
                break;
            case "EVENT":
                $tpl->assign("postTypeEventCount", $postContentType['cpostCount']);
                break;
            default:
                $tpl->assign("postTypeOthersCount", $postContentType['cpostCount']);
                break;
        }
    }
    
    foreach ($repostsByContentType as $repostContentType)
    {
        switch($repostContentType['ccontenttype'])
        {
            case "REGULAR":
                $tpl->assign("repostTypeRegularCount", $repostContentType['cpostCount']);
                break;
            case "LINK":
                $tpl->assign("repostTypeLinkCount", $repostContentType['cpostCount']);
                break;
            case "QUOTE":
                $tpl->assign("repostTypeQuoteCount", $repostContentType['cpostCount']);
                break;
            case "IMAGE":
                $tpl->assign("repostTypeImageCount", $repostContentType['cpostCount']);
                break;
            case "VIDEO":
                $tpl->assign("repostTypeVideoCount", $repostContentType['cpostCount']);
                break;
            case "FILE":
                $tpl->assign("repostTypeFileCount", $repostContentType['cpostCount']);
                break;
            case "REVIEW":
                $tpl->assign("repostTypeReviewCount", $repostContentType['cpostCount']);
                break;
            case "EVENT":
                $tpl->assign("repostTypeEventCount", $repostContentType['cpostCount']);
                break;
            default:
                $tpl->assign("repostTypeOthersCount", $repostContentType['cpostCount']);
                break;
        }
    }

    $tpl->assign("topPosts", $topPosts);
    $tpl->assign("topReposter", $topReposter);
    $tpl->assign("topFavs", $topFavs);

    $tpl->draw( "stats" ); // draw the template
?>