<?php require TOPFORFORMPAGES; ?>
<form action="/ax1/ByUsernameMessageProcessor/page" method="post">
    <h1>Username 💬 a User</h1>
    <?php require SESSIONMESSAGE; ?>
    <section>
        <p>
            <label for="username">U/N of Receiver: </label>
            <input id="username" name="username" type="text" required minlength="7" maxlength="12" size="12"
                   spellcheck="false">
        </p>
    </section>
    <?php require SUBMITABORT; ?>
</form>
<?php require BOTTOMOFPAGES; ?>