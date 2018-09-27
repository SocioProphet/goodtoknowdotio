<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/payment-form.css">
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
<form action="/ax1/ChangePasswordProcessor/page" method="post">
    <h1>Change Password</h1>
    <?php require SESSIONMESSAGE; ?>
    <section>
        <h2>All fields required</h2>
        <p>
            <label for="current_password">
                <span>Current P/W: </span>
            </label>
            <input type="password" id="current_password" name="current_password">
        </p>
        <p>
            <label for="first_try">
                <span>New P/W: </span>
            </label>
            <input type="password" id="first_try" name="first_try">
        </p>
        <p>
            <label for="new_password">
                <span>Reenter New P/W: </span>
            </label>
            <input type="password" id="new_password" name="new_password">
        </p>
    </section>
    <section>
        <p>
            <button type="submit" name="submit" value="Submit">Change Password</button>
        </p>
    </section>
</form>
</body>
</html>