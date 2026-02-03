
<input type="checkbox" id="theme-toggle" hidden>

<div class="site">
    <?php
session_start();
?>
<?php include 'include/head.php'; ?>
<?php include 'include/header.php'; ?>

<?php
if (!isset($_SESSION['level'])) {
    $_SESSION['level'] = 0;
}

$riddles = [
    ['text'=>'Имам корона, но не съм цар. Какво съм?', 'answer'=>'дърво', 'image'=>'images/image1.jpg'],
    ['text'=>'Лети без крила и плаче без очи. Какво е?', 'answer'=>'облак', 'image'=>'images/image2.jpg'],
    ['text'=>'Бяло поле, черно семе – кой го сее?', 'answer'=>'книга', 'image'=>'images/image3.jpg'],
];

$level = $_SESSION['level'];
$result = '';
$showHint = isset($_GET['hint']);

if ($level >= count($riddles)) {
    $finished = true;
} else {
    $finished = false;
    if (isset($_POST['answer'])) {
        $userAnswer = mb_strtolower(trim($_POST['answer']));
        if ($userAnswer === $riddles[$level]['answer']) {
            $result = '✅ Вярно! Продължаваш напред.';
            $_SESSION['level']++;
            header('Location: index.php');
            exit;
        } else {
            $result = '❌ Грешен отговор!';
        }
    }
}
?>
<main>
<?php if ($finished): ?>
    <div class="level-card">
        <h2>🎉 Поздравления!</h2>
        <p>Реши всички гатанки!</p>
        <a href="reset.php" class="btn">Започни отначало</a>
    </div>
<?php else: ?>
    <div class="level-card">
        <h2>Ниво <?= $level + 1 ?></h2>
        <p class="riddle-text"><?= $riddles[$level]['text'] ?></p>

        <form method="post">
            <input type="text" name="answer" placeholder="Твоят отговор" required>
            <button>Провери</button>
        </form>

        <?php if ($result): ?>
            <div class="result"><?= $result ?></div>
        <?php endif; ?>

        <?php if (!$showHint): ?>
            <a href="?hint=1" class="btn hint-btn">Жокер (покажи снимката)</a>
        <?php else: ?>
            <div class="hint-wrapper">
            <img src="<?= $riddles[$level]['image'] ?>" class="hint-img" alt="Жокер">
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
</main>
<?php include 'include/footer.php'; ?>
