<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title><?php echo $soupName;?>'s soup.io stats</title>
    <meta name="description" content="Your time is limited, so don’t waste it living someone else’s life." />

    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="template/minimal/assets/css/screen.css" />
    <link rel="stylesheet" type="text/css" href="template/minimal/assets/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic|Open+Sans:700,400" />
    <link rel="stylesheet" type="text/css" href="template/minimal/assets/css/basic.css">

    <link rel="alternate" type="application/rss+xml" title="Minimal Theme" href="template/minimal//rss/">
    <link rel="canonical" href="http://minimalv2-ghost1235.rhcloud.com/" />

    <link rel="stylesheet" href="template/minimal///cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>
<body style="background-image:url('template/minimal/assets/images/bg.jpg');" >
    <header id="site-head">
        <div class="vertical">
            <div id="site-head-content" class="inner">
                <h1 class="blog-title">Your soup.io stats</h1>
                <h2 class="blog-description">let us tell you something about your soup</h2>
            </div>
        </div>
    </header>
<br/>
<main class="content" role="main">
    <article class="post tag-getting-started">
        <img class='img-left' src="<?php echo $user["cavatar"];?>" alt='authorimage'>
        <br/>
        <header class="post-header">
            <h2 class="post-title">posts overall</h2>
            <br/>
            <div class="date-box">
                 <span class="date-outer">
                 <span class="date-inner">last updated <time datetime="<?php echo $user["clastcrawl"];?>"><?php echo $user["clastcrawl"];?></time></span>
                 </span>
            </div>
        </header>
        <section class="post-excerpt">
            <br>
            <div id="donuts-overall" class="container-donut-posts">
                <div class="donut-container clearfix">
                    <h3 class="donut-headline">by type</h3>
                    <div id="donut-posts-by-type" class="donut-chart"></div>
                </div>
                <div class="donut-container clearfix">
                    <h3 class="donut-headline">by content type</h3>
                    <div id="donut-posts-by-contenttype" class="donut-chart"></div>
                </div>
            </div>
        </section>
        <!--span class="post-meta"> on article</span-->
    </article>

    <br/>

    <article class="post tag-article">
        <img class='img-left' src="<?php echo $user["cavatar"];?>" alt='authorimage'>
        <br/>
        <header class="post-header">
           <h2 class="post-title"><a href="post.html">content by post type</a></h2>
           <br/>
           <div class="date-box">
                 <span class="date-outer">
                 <span class="date-inner">last updated <time datetime="<?php echo $user["clastcrawl"];?>"><?php echo $user["clastcrawl"];?></time></span>
                 </span>
            </div>
        </header>
        <section class="post-excerpt">
            <br>
            <div id="donuts-by-type" class="container-donut-posts">
                <div class="donut-container clearfix">
                    <h3 class="donut-headline">post content</h3>
                    <div id="donut-content-by-posttype-post" class="donut-chart"></div>
                </div>
                <div class="donut-container clearfix">
                    <h3 class="donut-headline">repost content</h3>
                    <div id="donut-content-by-posttype-repost" class="donut-chart"></div>
                </div>
            </div>
        </section>
        <!--span class="post-meta"> on article</span-->
    </article>

    <br/>

    <article class="post tag-image">
        <img src="<?php echo $user["cavatar"];?>" class='img-left' alt='authorimage'>
        <br/>
        <header class="post-header">
            <h2 class="post-title"><a href="post.html">Toplists</a></h2>
            <br/>
            <div class="date-box">
                <span class="date-outer">
                    <span class="date-inner">last updated <time datetime="<?php echo $user["clastcrawl"];?>"><?php echo $user["clastcrawl"];?></time></span>
                </span>
            </div>
        </header>
        <section class="post-excerpt">
            <br>
            <div class="toplist-container">
                <h3 class="toplist-headline">your top posts</h3>
                <div id="toplist-posts" class="toplist">
                    <table>
                        <tr>
                            <th>top</th>
                            <th>reposts</th>
                            <th>post</th>
                            <th>type</th>
                        </tr>
                        <?php $counter1=-1; if( isset($topPosts) && is_array($topPosts) && sizeof($topPosts) ) foreach( $topPosts as $key1 => $value1 ){ $counter1++; ?>
                        <tr>
                            <td><?php echo $counter1+1;?></td>
                            <td><?php echo $value1["crepostcounter"];?></td>
                            <td><a href="http://<?php echo $soupName;?>.soup.io/post/<?php echo ( substr( $value1["cpost"], 4 ) );?>"><?php echo $value1["cpost"];?></a></td>
                            <td><?php echo $value1["ccontenttype"];?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="toplist-container">
                <h3 class="toplist-headline">top reposter</h3>
                <div id="toplist-reposter" class="toplist">
                    <table>
                        <tr>
                            <th>top</th>
                            <th>reposts</th>
                            <th>user</th>
                        </tr>
                        <?php $counter1=-1; if( isset($topReposter) && is_array($topReposter) && sizeof($topReposter) ) foreach( $topReposter as $key1 => $value1 ){ $counter1++; ?>
                        <tr>
                            <td><?php echo $counter1+1;?></td>
                            <td><?php echo $value1["cpostcount"];?></td>
                            <td><a href="http://<?php echo $value1["crepostername"];?>.soup.io"><?php echo $value1["crepostername"];?></a></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="toplist-container">
                <h3 class="toplist-headline">your favorit soup users</h3>
                <div id="toplist-fav-users" class="toplist">
                    <table>
                        <tr>
                            <th>top</th>
                            <th>reposted</th>
                            <th>user</th>
                        </tr>
                        <?php $counter1=-1; if( isset($topFavs) && is_array($topFavs) && sizeof($topFavs) ) foreach( $topFavs as $key1 => $value1 ){ $counter1++; ?>
                        <tr>
                            <td><?php echo $counter1+1;?></td>
                            <td><?php echo $value1["ccount"];?></td>
                            <td><a href="http://<?php echo $value1["cfromsoupname"];?>.soup.io"><?php echo $value1["cfromsoupname"];?></a></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </section>
        <!--span class="post-meta"> on article</span-->
    </article>

    <br/>

    <article class="post tag-image">
        <img src="<?php echo $user["cavatar"];?>" class='img-left' alt='authorimage'>
        <br/>
        <header class="post-header">
            <h2 class="post-title"><a href="post.html">your activities</a></h2>
            <br/>
            <div class="date-box">
                <span class="date-outer">
                    <span class="date-inner">last updated <time datetime="<?php echo $user["clastcrawl"];?>"><?php echo $user["clastcrawl"];?></time></span>
                </span>
            </div>
        </header>
        <section class="post-excerpt">
            <br>
            <h3 class="activity-headline">last 7 days</h3>
            <div id="activity-last-7-days" class="activity-chart"></div>

            <h3 class="activity-headline">last 3 months</h3>
            <div id="activity-last-3-months" class="activity-chart"></div>

            <h3 class="activity-headline">this year</h3>
            <div id="activity-this-year" class="activity-chart"></div>

            <h3 class="activity-headline">last year</h3>
            <div id="activity-last-year" class="activity-chart"></div>
        </section>
        <!--span class="post-meta"> on article</span-->
    </article>
    <br/>
</main>

<footer class="site-footer">
<div class="pagelist">
<a href="Contact.html">Contact</a> /
<a href="#">Policy</a> /
<a href="#">Terms</a>
</div>
<div class="inner">
<section class="copyright">All content copyright <a href="/">Minimal Theme</a> &copy; 2013 &bull; All rights reserved.</section>

</div>
</footer>

    <!--script src="http://code.jquery.com/jquery-1.10.1.min.js"></script-->

    <script type="text/javascript" src="template/minimal/assets/js/index.js"></script>
    <script type="text/javascript" src="template/minimal/assets/js/jquery.fitvids.js"></script>
    <script>
        $(document).ready(function(){
            // Target your .container, .wrapper, .post, etc.
            $(".content").fitVids();
        });
    </script>
    <script>
        $(document).ready(function(){
            // Target your .container, .wrapper, .post, etc.
            $(".content").fitVids();
        });
    </script>
    <script src="template/minimal/assets/js/pace.js"></script>

    <!--script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script-->

    <script type="text/javascript">
        var postCount = <?php echo $postCount;?>;
        var repostCount = <?php echo $repostCount;?>;

        Morris.Donut({
            resize: true,
            element: 'donut-posts-by-type',
            colors: ["#C10202", "#912525", "#7D0101", "#E03A3A", "#E06666"],
            data: [
                {label: "posts", value: postCount},
                {label: "reposts", value: repostCount},
                {label: "total", value: (postCount + repostCount)}
            ]
        });

        var allPostTypeRegularCount =  <?php echo $postTypeRegularCount;?> + <?php echo $repostTypeRegularCount;?>;
        var allPostTypeLinkCount =     <?php echo $postTypeLinkCount;?> + <?php echo $repostTypeLinkCount;?>;
        var allPostTypeQuoteCount =    <?php echo $postTypeQuoteCount;?> + <?php echo $repostTypeQuoteCount;?>;
        var allPostTypeImageCount =    <?php echo $postTypeImageCount;?> + <?php echo $repostTypeImageCount;?>;
        var allPostTypeVideoCount =    <?php echo $postTypeVideoCount;?> + <?php echo $repostTypeVideoCount;?>;
        var allPostTypeFileCount =     <?php echo $postTypeFileCount;?> + <?php echo $repostTypeFileCount;?>;
        var allPostTypeReviewCount =   <?php echo $postTypeReviewCount;?> + <?php echo $repostTypeReviewCount;?>;
        var allPostTypeEventCount =    <?php echo $postTypeEventCount;?> + <?php echo $repostTypeEventCount;?>;

        Morris.Donut({
            resize: true,
            element: 'donut-posts-by-contenttype',
            colors: ["#C10202", "#912525", "#7D0101", "#E03A3A", "#E06666"],
            data: [
                {label: "texts",    value: allPostTypeRegularCount},
                {label: "images",   value: allPostTypeImageCount},
                {label: "links",    value: allPostTypeLinkCount},
                {label: "quotes",   value: allPostTypeQuoteCount},
                {label: "videos",   value: allPostTypeVideoCount},
                {label: "files",    value: allPostTypeFileCount},
                {label: "reviews",  value: allPostTypeReviewCount},
                {label: "events",   value: allPostTypeEventCount}
            ]
        });

        var postCount = <?php echo $postCount;?>;
        var repostCount = <?php echo $repostCount;?>;

        Morris.Donut({
            resize: true,
            element: 'donut-content-by-posttype-post',
            colors: ["#C10202", "#912525", "#7D0101", "#E03A3A", "#E06666"],
            data: [
                {label: "texts",    value: <?php echo $postTypeRegularCount;?>},
                {label: "images",   value: <?php echo $postTypeImageCount;?>},
                {label: "links",    value: <?php echo $postTypeLinkCount;?>},
                {label: "quotes",   value: <?php echo $postTypeQuoteCount;?>},
                {label: "videos",   value: <?php echo $postTypeVideoCount;?>},
                {label: "files",    value: <?php echo $postTypeFileCount;?>},
                {label: "reviews",  value: <?php echo $postTypeReviewCount;?>},
                {label: "events",   value: <?php echo $postTypeEventCount;?>}
            ]
        });

        Morris.Donut({
            element: 'donut-content-by-posttype-repost',
            colors: ["#C10202", "#912525", "#7D0101", "#E03A3A", "#E06666"],
            data: [
                {label: "texts",    value: <?php echo $repostTypeRegularCount;?>},
                {label: "images",   value: <?php echo $repostTypeImageCount;?>},
                {label: "links",    value: <?php echo $repostTypeLinkCount;?>},
                {label: "quotes",   value: <?php echo $repostTypeQuoteCount;?>},
                {label: "videos",   value: <?php echo $repostTypeVideoCount;?>},
                {label: "files",    value: <?php echo $repostTypeFileCount;?>},
                {label: "reviews",  value: <?php echo $repostTypeReviewCount;?>},
                {label: "events",   value: <?php echo $repostTypeEventCount;?>}
            ]
        });
    </script>
</body>
</html>