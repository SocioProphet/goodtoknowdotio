<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title><?php /** @noinspection PhpUndefinedVariableInspection */
        echo $html_title; ?></title>
</head>
<body>
<!-- topbar -->
<div id="topbar">
    <a href="https://goodtoknow.io/ax1"><img src="/good1.jpg" alt="GoodToKnow.io" height="70" width="302"
                                             style="float: left"></a>
    <div id="sendmessage"><?php require SENDMESSAGELINK; ?></div>
    <div id="inboxlink"><p><a href="/ax1/ByUsernameMessage/page">U/N 📧 👲</a></p></div>
    <div id="logindiv"><p><a href="/ax1/Logout/page">👋 log out</a></p></div>
</div>
<!-- communities -->
<div id="communities">
    <p>👪:&nbsp;&nbsp;<?php require COMMUNITIESFORTHISUSER; ?></p>
</div>
<!-- breadcrumbs -->
<div id="breadcrumbs">
    <p>⛺:&nbsp;&nbsp;
        <a href="/ax1/SetHomePageCommunityTopicPost/page/<?php echo $community_id; ?>/0/0"><?php echo $community_name; ?></a>
        <?php require CURRENTTOPIC; ?><?php require CURRENTPOST; ?></p>
</div>
<!-- scriptoutput -->
<div id="scriptoutput">
    <div id="leftsodiv">
        <div id="sendtoauthor"><?php require MESSAGETHEAUTHOR; ?></p></div>
        <div id="admindiv">
            <?php require CONTROLPANELLINK; ?>
        </div>
    </div>
    <div id="scriptmessage">
        <?php require SESSIONMESSAGE; ?>
    </div>
</div>
<!-- maincontent -->
<div id="maincontent">
    <?php if (!empty($inbox_messages_array)): ?>
        <?php foreach ($inbox_messages_array as $message): ?>
            <p><b>Time: </b><?php echo $message->created; ?></p>
            <p><b>Sender: </b><?php echo $message->user_id; ?></p>
            <?php echo $message->content; ?>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No messages.</p>
    <?php endif; ?>
</div><!-- End maincontent -->
<!-- footerbar -->
<div id="footerbar">
    <p align="center" style="font-size: 1em;">
        <img src="/Gnu-head-30-years-anniversary.svg" style="float:left;height: 32px;width: 32px;margin-top: -6px">
        © 2018 - Sameh Ramzy Labib
        <img src="/2000px-GPLv3_Logo.svg.png"
             height="32" width="70"
             style="float:right;;margin-top: -6px"></p>
</div>
<script src="/js/script.js"></script>
</body>
</html>