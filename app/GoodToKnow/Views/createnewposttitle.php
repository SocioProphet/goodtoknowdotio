<?php require TOPFORFORMPAGES; ?>
    <form action="/ax1/CreateNewPostTitleProcessor/page" method="post">
        <h2>Create a title</h2>
        <p class="tooltip">ℹ️
            <span class="tooltiptext tooltip-top">The main title is title which appears in a listing of posts for topic.
        While title extension is meta data. ✅ emoji. Both fields required</span>
        </p>
        <?php require SESSIONMESSAGE; ?>
        <section>
            <p>
                <label for="title">Main title: </label>
                <input id="title" name="main_title" type="text" value="" required minlength="1" maxlength="200"
                       size="60" spellcheck="false">
            </p>
            <p>
                <label for="extension">Title extension: </label>
                <input id="extension" name="title_extension" type="text" value="" required minlength="1" maxlength="200"
                       size="60" spellcheck="false">
            </p>
        </section>
        <?php require SUBMITABORT; ?>
    </form>
<?php require BOTTOMOFPAGES; ?>