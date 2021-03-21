<?php

require __DIR__ . '/vendor/autoload.php';

$word = trim($_GET['word']);

if (!empty($word)) {
    $voikko = new \Siiptuo\Voikko\Voikko();
    $analyses = $voikko->analyzeWord($word);
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>voikko-web</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>voikko-web</h1>
        <p>This tool allows you to look up Finnish words and return their morphological analysis. It's powered by <a href="https://voikko.puimula.org/">voikko</a> and <a href="https://github.com/siiptuo/voikko-php">voikko-php</a>.</p>
        <form action="" method="GET">
            <input type="text" name="word" value="<?= htmlspecialchars($word) ?>" placeholder="Enter word">
            <button type="submit">Search</button>
        </form>
        <?php if (isset($analyses)): ?>
            <?php foreach ($analyses as $analysis): ?>
                <h2 lang="fi"><?= htmlspecialchars($analysis->baseForm) ?></h2>
                <table>
                    <?php if (isset($analysis->baseForm)): ?>
                        <tr>
                            <th>Base form</th>
                            <td lang="fi"><?= htmlspecialchars($analysis->baseForm) ?></td>
                        </tr>
                    <?php endif ?>
                    <?php if (isset($analysis->class)): ?>
                        <tr>
                            <th>Class</th>
                            <td lang="fi"><?= htmlspecialchars($analysis->class) ?></td>
                        </tr>
                    <?php endif ?>
                    <?php if (isset($analysis->fstOutput)): ?>
                        <tr>
                            <th>FST output</th>
                            <td><?= htmlspecialchars($analysis->fstOutput) ?></td>
                        </tr>
                    <?php endif ?>
                    <?php if (isset($analysis->number)): ?>
                        <tr>
                            <th>Number</th>
                            <td><?= htmlspecialchars($analysis->number) ?></td>
                        </tr>
                    <?php endif ?>
                    <?php if (isset($analysis->sijamuoto)): ?>
                        <tr>
                            <th lang="fi">Sijamuoto</th>
                            <td lang="fi"><?= htmlspecialchars($analysis->sijamuoto) ?></td>
                        </tr>
                    <?php endif ?>
                    <?php if (isset($analysis->structure)): ?>
                        <tr>
                            <th>Structure</th>
                            <td><?= htmlspecialchars($analysis->structure) ?></td>
                        </tr>
                    <?php endif ?>
                    <?php if (isset($analysis->wordBases)): ?>
                        <tr>
                            <th>Word bases</th>
                            <td><?= htmlspecialchars($analysis->wordBases) ?></td>
                        </tr>
                    <?php endif ?>
                </table>
            <?php endforeach ?>
        <?php endif ?>
    </body>
</html>
