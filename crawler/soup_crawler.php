<pre>
<?php
// CSS CLASSES
// POST: post <TYPE> author-self source-local
// RE-POST: post post_image author-self post_repost source-local
// POST Types: post_regular, post_link, post_quote, post_image, post_video, post_file, post_review, post_event
// RSS IMPORTS: ... <TYPE> imported ...
// REACTIONS: ... <TYPE> post_reaction ...

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

require("../vendor/autoload.php");
require("db_soup.class.php");

$mainUrl = "http://psaiko.soup.io";
$loopStop = $mainUrl;
$url = $mainUrl;
$next = null;
$x = 1;
$timeStart = microtime(true);

$db = new soupDB();
$soupID = "";
$soupPostID_tmp = "";
$soupRepostCounterCorrection = 0;
$statsPosts = array();
$statsRePosts = array();
$statsError = array();

function defineContentType($classes)
{
    if(strpos($classes, "post_regular"))
    {
        return "REGULAR";
    }

    if(strpos($classes, "post_link"))
    {
        return "LINK";
    }

    if(strpos($classes, "post_quote"))
    {
        return "QUOTE";
    }

    if(strpos($classes, "post_image"))
    {
        return "IMAGE";
    }

    if(strpos($classes, "post_video"))
    {
        return "VIDEO";
    }

    if(strpos($classes, "post_file"))
    {
        return "FILE";
    }

    if(strpos($classes, "post_review"))
    {
        return "REVIEW";
    }

    if(strpos($classes, "post_event"))
    {
        return "EVENT";
    }

    return "UNKNOWN";
}

function isReaction($classes)
{
    if(strpos($classes, "post_reaction"))
    {
        return 1;
    }

    return 0;
}

function isImported($classes)
{
    if(strpos($classes, "imported"))
    {
        return 1;
    }

    return 0;
}

function analyseRePoster($index, $elementDOMNode)
{
    global $db;
    global $soupID;
    global $soupPostID_tmp;
    global $soupRepostCounterCorrection;

    $element = qp($elementDOMNode);
    $cssClasses = $element->attr("class");

    $cssTMP = explode(" ", $cssClasses);
    //print_r($cssTMP);
    if($cssTMP[0] == "name")
    {
        $soupRepostCounterCorrection++;
    }
    else
    {
        $soupReposterID = $cssTMP[2];
        $url = $element->find("a.url")->attr("href");
        $parsedURL = parse_url($url);
        $host = explode(".", $parsedURL['host']);
        $soupReposterName = $host[0];

        $db->addReposter($soupID, $soupPostID_tmp, $soupReposterID, $soupReposterName);
    }
}

function analysePost($index, $elementDOMNode)
{
    global $db;
    global $soupID;
    global $soupPostID_tmp;
    global $statsPosts;
    global $statsRePosts;
    global $statsErrors;
    global $soupRepostCounterCorrection;

    $postOrRePost = "";
    $string = "";

    //print $element->tagName . PHP_EOL;
    $element = qp($elementDOMNode);
    $cssClasses = $element->attr("class");

    $posterName = "";
    $posterID = "";
    $viaName = "";
    $viaID = "";
    $postRepostCounter = 0;

    $postContentType = defineContentType($cssClasses);
    $postIsReaction = isReaction($cssClasses);
    $postIsImported = isImported($cssClasses);

    if(strlen(strstr($cssClasses, "post_repost")) > 0)
    {
        $postOrRePost = "REPOST";

        // *** post ID ***
        $postID = $element->attr("id");
        $soupPostID_tmp = $postID;
        $string .= "REPosted ";
        $string .= substr($postID, 4) . " ";

        // *** poster name ***
        $strangers = $element->find("span.name")->text() . " ";
        $strangers = explode(" ", $strangers);
        $posterName = $strangers[1];
        $string .= "from ";
        $string .= $posterName;

        // *** poster ID ***
        $postUserSources = $element->find("div.source span");
        $posterCSSClasses = explode(" ", $postUserSources->attr("class"));
        $posterID = $posterCSSClasses[2];
        $string .= "(" . substr($posterID, 4) . ") ";

        // *** via ***
        if(count($strangers) > 3)
        {
            $viaCSSClasses = explode(" ", $postUserSources->next()->attr("class"));
            $viaID = $viaCSSClasses[2];
            $viaName = $strangers[2];
            $string .= "via " . $viaName;
            $string .= "(" . substr($viaID, 4) . ") ";
        }
    }
    else
    {
        $postOrRePost = "POST";
        // *** post id ***
        $postID = $element->attr("id");
        $soupPostID_tmp = $postID;
        $string .= "Posted ";
        $string .= substr($postID, 4) . " ";
    }

    // *** TIME ***
    $dateString = $element->find("span.time abbr")->attr("title");
    date_default_timezone_set('UTC');
    $timestamp = strtotime($dateString);
    $postDate = date("Y-m-d", $timestamp);
    $postTime = date("H:m:s", $timestamp);
    $string .= "on " . $postDate . " " . $postTime . " ";


    // *** repost counter ***
    if($postOrRePost == "POST")
    {
        $postReposts = $element->find("div.reposted_by span");
        $postRepostCounter = count($postReposts);
        if($postRepostCounter == 1)
        {
            $string .= "and was reposted by one person ";
        }
        elseif($postRepostCounter > 1)
        {
            $string .= "and was reposted " . $postRepostCounter . " times ";
        }

        $postReposter = $postReposts->each("analyseRePoster");
    }


    echo $string . "\n";

    // *** fill db arrays ***
    switch($postOrRePost)
    {
        case "POST":
            $post =& $statsPosts;
            break;
        case "REPOST":
            $post =& $statsRePosts;
            break;
        default:
            $post =& $statsErrors;
            break;
    }

    $post[$postID] = array(":cuserid" => $soupID,
        ":cpost" => $postID,
        ":cfromsoupname" => $posterName,
        ":cfromsoupid" => $posterID,
        ":cviasoupname" => $viaName,
        ":cviasoupid" => $viaID,
        ":crepostcounter" => $postRepostCounter - $soupRepostCounterCorrection,
        ":cdate" => $postDate,
        ":ctime" => $postTime,
        ":cposttype" => $postOrRePost,
        ":ccontenttype" => $postContentType,
        ":creaction" => $postIsReaction,
        ":cimported" => $postIsImported
    );

    $soupRepostCounterCorrection = 0;
}


while($next != $loopStop)
{
    if(null !== $next)
    {
        $url = $next;
    }

    echo "\n\n" . $url . "\n";

    $html = htmlqp($url);

    if(strlen($soupID) < 1)
    {
        $parsedURL = parse_url($url);
        $host = explode(".", $parsedURL['host']);
        $username = $host[0];

        $userInformationTMP = explode(" ", $html->find("div.vcard a img")->attr("class"));
        $userAvatarUrl = $html->find("div.vcard a img")->attr("src");
        $soupID = $userInformationTMP[2];

        $db->addUser($soupID, $username, $userAvatarUrl);

        $resumeSince = $db->getLastCrawlPosition($soupID);
        if($resumeSince)
        {
            $next = "http://" . $parsedURL['host'] . "/since/" . $resumeSince;
            continue;
        }
    }

    $nextButton = $html->find("a.more");
    $nextLink = $nextButton->attr("href");

    $next = explode('?', $nextLink);
    $since = explode('/', $next[0]);
    $since = $since[2];
    $next = $mainUrl . $next[0];


    // Iterate using a callback function
    $posts = $html->find("div.post")->each('analysePost');
    //break;


    //*/
    foreach($statsPosts as $statsPost)
    {
        if(!$db->insertPost($statsPost))
        {
            $db->updateRepostCount($statsPost);
        }
    }
    $statsPosts = Array();

    foreach($statsRePosts as $statsRePost)
    {
        if(!$db->insertPost($statsRePost))
        {
            break;
        }
    }
    $statsRePosts = Array();
    //*/

    $db->updateSince($soupID, $since);
}

$db->updateSince($soupID, 0);

$timeEnd = microtime(true);
$runtime = $timeEnd - $timeStart;
echo "\n FINISHED \n runtime " . date("H:i:s", $runtime) . "\n\n";
?>
