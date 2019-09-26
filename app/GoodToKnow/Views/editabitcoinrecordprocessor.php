<?php require TOPFORFORMPAGES; ?>
    <form action="/ax1/EditABitcoinRecordSubmit/page" method="post">
        <h2><?php /** @noinspection PhpUndefinedVariableInspection */
            echo $bitcoin_object->address; ?></h2>
        <?php require SESSIONMESSAGE; ?>
        <section>
            <p>
                <label for="initial_balance">Initial BTC Balance: </label>
                <input id="initial_balance" name="initial_balance" type="text" placeholder="0.00000000"
                       value="<?= $bitcoin_object->initial_balance ?>"
                       minlength="10" spellcheck="false" size="17" maxlength="17">
            </p>
            <p>
                <label for="current_balance">Current BTC Balance: </label>
                <input id="current_balance" name="current_balance" type="text" placeholder="0.00000000"
                       value="<?= $bitcoin_object->current_balance ?>" required
                       minlength="10" spellcheck="false" size="17" maxlength="17">
            </p>
            <p>
                <label for="currency">Currency (✅ emoji): </label>
                <input id="currency" name="currency" type="text"
                       value="<?= $bitcoin_object->currency ?>" required minlength="1" maxlength="15" size="15">
            </p>
            <p>
                <label for="price_point">BTC Price at Time of Purchase: </label>
                <input id="price_point" name="price_point" type="text" placeholder="0.00"
                       value="<?= $bitcoin_object->price_point ?>"
                       minlength="2" spellcheck="false" size="13" maxlength="13">
            </p>
            <hr>
            <p>Time at Purchase</p>
            <?php require TIMEFORMFIELDPREFILLED; ?>
            <hr>
            <p>
                <label for="comment">Comment (🚫 markdown ✅ emoji ✅ line-break): </label>
                <textarea id="comment" name="comment" rows="4" cols="71" wrap="soft" maxlength="800" spellcheck="false"
                          placeholder="This record is for BTC related to _ _ _ _ _."><?= $bitcoin_object->comment ?></textarea>
            </p>
        </section>
        <?php require SUBMITABORT; ?>
    </form>
<?php require BOTTOMOFPAGES; ?>