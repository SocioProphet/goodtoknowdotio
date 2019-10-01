<?php require TOPFORFORMPAGES; ?>
<form action="/ax1/StartATaxableIncomeEventProcessor/page" method="post">
    <h1>Create a Taxable 💸 Event 📽</h1>
    <?php require SESSIONMESSAGE; ?>
    <section>
        <p>
            <label for="label">Label (✅ emoji): </label>
            <input id="label" name="label" type="text" value="" required minlength="3" maxlength="264"
                   size="61" spellcheck="false" placeholder="Technical support for a Gtk.io User">
        </p>
        <hr>
        <p>Time The Event Occured</p>
        <?php require TIMEFORMFIELD; ?>
        <hr>
        <p>
            <label for="year_received">Year for when event occured: </label>
            <input id="year_received" name="year_received" type="text" value="" required minlength="4" maxlength="6"
                   size="6" placeholder="2018">
        </p>
        <p>
            <label for="currency">Currency (✅ emoji): </label>
            <input id="currency" name="currency" type="text" value="" required minlength="1" maxlength="15" size="15"
                   placeholder="💵">
        </p>
        <p>
            <label for="amount">Amount of currency received: </label>
            <input id="amount" name="amount" type="text" value="" required minlength="1" maxlength="24" size="24"
                   placeholder="150.24">
        </p>
        <p>
            <label for="comment">Comment (🚫 markdown ✅ emoji ✅ line-break): </label>
            <textarea id="comment" name="comment" rows="4" cols="71" wrap="soft" maxlength="800"
                      placeholder="The frequency of this income is _ _ _ _."></textarea>
        </p>
    </section>
    <?php require SUBMITABORT; ?>
</form>
<?php require BOTTOMOFPAGES; ?>