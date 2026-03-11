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
    ['text'=>'Имам пера, но не съм птица. Имам чаршафи, но не съм легло.', 'answer'=>'възглавница', 'image'=>'images/image3.jpg'],
    ['text'=>'Колкото повече застарявам, толкова по-ниска ставам.', 'answer'=>'свещ', 'image'=>'images/image2.jpg'],
    ['text'=>'Имам зъби, но не мога да ям.', 'answer'=>'гребен', 'image'=>'images/image2.jpg'],
    ['text'=>'Крака няма,а тича. Уста няма,а шуми.', 'answer'=>'река', 'image'=>'images/image1.jpg'],
    ['text'=>'Падам, но никога не се наранявам.', 'answer'=>'дъжд', 'image'=>'images/image1.jpg'],
    ['text'=>'Колкото повече ме сушиш, толкова по-мокра ставам.', 'answer'=>'кърпа', 'image'=>'images/image1.jpg'],
    ['text'=>'Имам лице, но нямам очи. Имам стрелки, но нямам лък.', 'answer'=>'часовник', 'image'=>'images/image1.jpg'],
    ['text'=>'Имам градове, но няма къщи. Имам планини, но няма дървета.', 'answer'=>'карта', 'image'=>'images/image1.jpg'],
    ['text'=>'Винаги идвам, но никога не пристигам днес.', 'answer'=>'утре', 'image'=>'images/image1.jpg'],
    ['text'=>'Какво се пълни с празни ръце?', 'answer'=>'ръкавица', 'image'=>'images/image1.jpg'],
    ['text'=>'Колкото повече вземаш от мен, толкова по-голяма ставам.', 'answer'=>'дупка', 'image'=>'images/image1.jpg'],
    ['text'=>'Какво принадлежи на теб, но другите го ползват по-често? ', 'answer'=>'името ти', 'image'=>'images/image1.jpg'],
    ['text'=>'Какво можеш да го хванеш,но не и да хвърлиш?', 'answer'=>'болест', 'image'=>'images/image1.jpg'],
    ['text'=>'Какво се чупи, дори само ако му кажеш името?', 'answer'=>'тишина', 'image'=>'images/image1.jpg'],
    ['text'=>'Кое е това, което го хвърляш, когато ти трябва, и го прибираш, когато не ти трябва?', 'answer'=>'котва', 'image'=>'images/image1.jpg'],
    ['text'=>'Мога да запълня цяла стая, но не заемам никакво място.', 'answer'=>'светлина', 'image'=>'images/image1.jpg'],
    ['text'=>'Нямам глас, но ти отговарям винаги, когато ми говориш.', 'answer'=>'ехото', 'image'=>'images/image1.jpg'],
    ['text'=>'Колкото повече от него има, толкова по-малко виждаш.', 'answer'=>'мракът', 'image'=>'images/image1.jpg'],
    ['text'=>'Винаги бяга от теб, но не можеш да го изпревариш.', 'answer'=>'хоризонт', 'image'=>'images/image1.jpg'],
    ['text'=>'Аз съм лек като перце, но и най-силният човек не може да ме държи дълго.', 'answer'=>'дъх', 'image'=>'images/image1.jpg'],
    ['text'=>'Какво има една дупка, когато влизаш, и две, когато излизаш?', 'answer'=>'панталони', 'image'=>'images/image1.jpg'],
    ['text'=>'Кое е това нещо, което се мокри, докато те пази от дъжда?', 'answer'=>'чадър', 'image'=>'images/image1.jpg'],
    ['text'=>'Кое е това, което минава през градове и полета, но никога не се движи?', 'answer'=>'път', 'image'=>'images/image1.jpg'],
    ['text'=>'Ако ме имаш, искаш да ме споделиш. Ако ме споделиш, вече ме нямаш.', 'answer'=>'тайна', 'image'=>'images/image1.jpg'],
    ['text'=>'Дай ми храна и ще живея. Дай ми вода и ще умра.', 'answer'=>'огън', 'image'=>'images/image1.jpg'],
    ['text'=>'Имам ключове, но няма ключалки. Имам пространство, но няма стаи. Можеш да влезеш (Enter), но не можеш да излезеш.', 'answer'=>'клавиатура', 'image'=>'images/image1.jpg'],
    ['text'=>'Аз не съм нищо, но имам име. Понякога съм висока, понякога ниска. Не мога да мисля, но се движа с теб.', 'answer'=>'сянка', 'image'=>'images/image1.jpg'],
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
