<?php
session_start();

if (!isset($_SESSION['started'])) {
    $_SESSION['started'] = false;
}

if (!isset($_SESSION['level'])) {
    $_SESSION['level'] = 0;
}

if (!isset($_SESSION['points'])) {
    $_SESSION['points'] = 0;
}

$riddles = [
    ['text'=>'Имам корона, но не съм цар. Какво съм?', 'answer'=>'дърво', 'image'=>'images/image1.jpg'],
    ['text'=>'Лети без крила и плаче без очи. Какво е?', 'answer'=>'облак', 'image'=>'images/image2.jpg'],
    ['text'=>'Бяло поле, черно семе – кой го сее?', 'answer'=>'книга', 'image'=>'images/image3.jpg'],
];

$level = $_SESSION['level'];
$result = '';
$showHint = isset($_GET['hint']);

if (isset($_POST['start'])) {
    $_SESSION['started'] = true;
    $_SESSION['level'] = 0;
    $_SESSION['points'] = 0;
    header("Location: index.php");
    exit;
}

$finished = $level >= count($riddles);


if (!$finished && isset($_POST['answer'])) {
    $userAnswer = mb_strtolower(trim($_POST['answer']));

    if ($userAnswer === $riddles[$level]['answer']) {
        $_SESSION['points'] += 10;
        $_SESSION['level']++;
        header("Location: index.php");
        exit;
    } else {
        $result = '❌ Грешен отговор!';
    }
}
?>
<!DOCTYPE html>
<html lang="bg">
<?php include 'include/head.php'; ?>
<body>

<div class="site">
<?php include 'include/header.php'; ?>

<main>

<?php if (!$_SESSION['started']): ?>
    <div class="level-card">
        <h2>🧠 Гатанки</h2>
        <p>Готов ли си да тестваш ума си?</p>
        <form method="post">
            <button name="start">▶ Старт</button>
        </form>
    </div>

<?php elseif ($finished): ?>
    <div class="level-card">
        <h2>🏁 Край на играта</h2>
        <p>Общ резултат:</p>
        <h3>⭐ <?= $_SESSION['points'] ?> точки</h3>
        <a href="reset.php" class="btn">🔄 Играй отново</a>
    </div>

<?php else: ?>
    <div class="level-card">
        <h2>Ниво <?= $level + 1 ?></h2>
        <p>⭐ Точки: <?= $_SESSION['points'] ?></p>

        <p class="riddle-text"><?= $riddles[$level]['text'] ?></p>

        <form method="post">
            <input type="text" name="answer" placeholder="Твоят отговор" required>
            <button>Провери</button>
        </form>

        <?php if ($result): ?>
            <div class="result"><?= $result ?></div>
        <?php endif; ?>

        <?php if (!$showHint): ?>
            <a href="?hint=1" class="btn hint-btn">Жокер</a>
        <?php else: ?>
            <div class="hint-wrapper">
                <img src="<?= $riddles[$level]['image'] ?>" class="hint-img">
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

</main>

<?php include 'include/footer.php'; ?>
</div>
</body>
</html>
