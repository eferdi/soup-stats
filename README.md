soup-stats
==========

get stats about your soup.io account

Why
===
soup.io is a popular tumblog. But like her big brother tumblr it lacks on statistic informations about your posts.
For example how many have you postet, how many repostet and what was reposted at most by others...

Roadmap
======
v0.5
- [X] only local usage for one soup.io account (but in the foresight to have multiple users) [DONE]
- crawl soup.io pages [WIP]
- get informations: how many ... pages, posts, reposts, friends, groups, followers, post dates [WIP]
- get the type of the posts and reposts [DONE]
- display some fancy charts [WIP]
- save data to be sure not to crawl the pages every time [WIP]

v0.9
- get a live version for this tool
- bigges problem will be the crawler, he needs some time and have to run in background, maybe we use some background processing like gearman (http://http://gearman.org/)
- ~~multi user support (register, login, delete...)~~ [CANCELED] no user registration necessary, because only public data will be crawled

v1
- tested version of all above

v1.5
- add social tralala (share on xyz)

v2
- maybe we add other tumblogs
