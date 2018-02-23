<footer>
    <ul class="footer-col" id="column-a">
        <li><h3>Навигация</h3></li>
        <li><a href="{{ url('/') }}">Главная</a></li>
        <li><a href="{{ url('/recipes') }}">Рецепты</a></li>
        <li><a href="{{ url('/contact') }}">Связь с нами</a></li>
    </ul>

    <ul class="footer-col" id="column-b">
        <li><h3>Условия и приватность</h3></li>
        <li><a href="#">О нас</a></li>
        <li><a href="#">Условия</a></li>
        <li><a href="#">Конфиденциальность</a></li>
    </ul>

    <div class="copyright" id="column-c">
        <li>Copyright &copy; {{ date("Y") }}</li>
    </div>
</footer>