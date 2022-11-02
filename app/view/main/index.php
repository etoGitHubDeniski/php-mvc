<p>Что бы не реализовывать сейчас авторизацию поставил смену сессии по перезагрузке страницы</p>
<?php if (!isset($_SESSION['user'])) : ?>
    <?php $_SESSION['user'] = 'Denis'; ?>
    <p>Привет авторизованный User: <?=$_SESSION['user']?></p>
<?php else : ?>
    <?php unset($_SESSION['user']); ?>
    <p>Привет гость</p>
<?php endif; ?>

<p><a href="/profile">Открыть профиль</a></p>
