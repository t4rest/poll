# basic template

## SCSS

* двойные (2) отступы пробелом, никаких табов;
* в идеале, 80-символьную ширину строк;
* правильно написанные многострочные CSS правила;
* осмысленное использование пробелов.

$font-stack: 'Helvetica Neue Light', 'Helvetica', 'Arial', sans-serif;

.foo {
  background-image: url('/images/kittens.jpg');
}

.foo {
  padding: 2em;
  opacity: 0.5;
}

$length: 0;

$value: 42;
$length: $value * 1px;

$value: 42 + 0px;
// -> 42px

$value: 1in + 0px;
// -> 1in

$value: 0px + 1in;
// -> 96px


$length: 42px;
$value: $length / 1px;

.foo {
  width: (100% / 3);
}

## SCSS Colors

.foo {
  color: red;
}
.foo {
  color: rgba(0, 0, 0, 0.1);
  background: hsl(300, 100%, 100%);
}

$sass-pink: #c69;
$main-theme-color: $sass-pink;


$font-stack: 'Helvetica', 'Arial', sans-serif;

## css
.foo, .foo-bar,
.baz {
  display: block;
  overflow: hidden;
  margin: 0 auto;
}


* локальные переменные объявляются перед любыми объявлениями, потом отделяются от деклараций новой строкой;
* вызовы примесей без @content идут перед любым объявлением;
* вложенные селекторы всегда идут после новой строки;
* вызовы примесей с @content идут после вложенных селекторов;
* без новых строк перед закрывающей фигурной скобкой (}).

.foo, .foo-bar,
.baz {
  $length: 42em;

  @include ellipsis;
  @include size($length);
  display: block;
  overflow: hidden;
  margin: 0 auto;

  &:hover {
    color: red;
  }

  @include respond-to('small') {
    overflow: visible;
  }
}


** Порядок свойств (пример), возможно небольшая перестановка свойств для удобства

.foo {
  width: 100px;
  height: 100px;
  position: absolute;
  right: 0;
  bottom: 0;
  background: black;
  overflow: hidden;
  color: white;
  font-weight: bold;
  font-size: 1.5em;
}


** Вкладывание селекторов

.foo {
  .bar {
    &:hover {
      color: red;
    }
  }
}

.foo {
  &-bar {
    color: red;
  }
}

.foo {
  color: red;

  &:hover {
    color: green;
  }

  &::before {
    content: 'псевдоэлемент';
  }
}

.foo {
  // …

  &.is-active {
    font-weight: bold;
  }
}

// if .foo inside ('.no-opacity') 
.foo {
  // …

  .no-opacity & {
    display: none;
  }
}


## Соглашения по именованию

$vertical-rhythm-baseline: 1.5rem;

@mixin size($width, $height: $width) {
  // …
}

@function opposite-direction($direction) {
  // …
}

## Константы

$CSS_POSITIONS: top, right, bottom, left, center;


## Написание комментариев

// Добавить текущий модуль в список импортируемых модулей.
// `!global` – важный флаг для глобального обновления переменной.
$imported-modules: append($imported-modules, $module) !global;

## Документирование

/// Вертикальный ритм, использующийся во всём коде.
/// @type Length
$vertical-rhythm-baseline: 1.5rem;



# Шаблон 7-1

sass/
|
|– base/
|   |– _reset.scss       # Reset/normalize
|   |– _typography.scss  # Типографские правила
|   …                    # и т.д.
|
|– components/
|   |– _buttons.scss     # Кнопки
|   |– _carousel.scss    # Карусель
|   |– _cover.scss       # Обложка
|   |– _dropdown.scss    # Выпадающий список
|   …                    # и т.д.
|
|– layout/
|   |– _navigation.scss  # Навигация
|   |– _grid.scss        # Сетка
|   |– _header.scss      # Шапка
|   |– _footer.scss      # Подвал
|   |– _sidebar.scss     # Боковая панель
|   |– _forms.scss       # Формы
|   …                    # и т.д.
|
|– pages/
|   |– _home.scss        # Стили, особые для главной страницы
|   |– _contact.scss     # Стили, особые для страницы контактов
|   …                    # и т.д.
|
|– themes/
|   |– _theme.scss       # Тема по умолчанию
|   |– _admin.scss       # Тема админа
|   …                    # и т.д.
|
|– utils/
|   |– _variables.scss   # Переменные Sass
|   |– _functions.scss   # Функции Sass
|   |– _mixins.scss      # Примеси Sass
|   |– _helpers.scss     # Помощники классов & placeholder’ов
|
|– vendors/
|   |– _bootstrap.scss   # Bootstrap
|   |– _jquery-ui.scss   # jQuery UI
|   …                    # и т.д.
|
|
`– main.scss             # главный файл Sass


# Адаптивный веб-дизайн и точки остановки

## Именование точек остановки

$breakpoints: (
  'medium': (min-width: 800px),
  'large': (min-width: 1000px),
  'huge': (min-width: 1200px),
);

/// Управление отзывчивостью.
/// @access public
/// @param {String} $breakpoint - точка остановки
/// @requires $breakpoints
@mixin respond-to($breakpoint) {
  @if map-has-key($breakpoints, $breakpoint) {
    @media #{inspect(map-get($breakpoints, $breakpoint))} {
      @content;
    }
  } @else {
    @error 'Не указано значение для `#{$breakpoint}`. '
         + 'Пожалуйста, убедитесь, что точка остановки объявлена в карте `$breakpoints`.';
  }
}

## Использование медиа-запросов

.foo {
  color: red;

  @include respond-to('medium') {
    color: blue;
  }
}


# Переменные

$variable: 'initial value';
$baseline: 1em !default;


## Подводя итог, мы хотим:

Отступ двумя (2) пробелами, никаких табов;
Строки шириной в 80 символов;
Правильно написанный многострочный CSS;
Осмысленное использование пробелов;
Строки и URL в одиночных кавычках;
Не опускать 0, обязательно ставить 0 в начале для чисел меньше 1;
Вычисления оборачивать в скобки;
Никаких магических чисел;
Цвета ключевыми словами > HSL > RGB > шестнадцатеричные;
Списки, разделённые запятыми;
Без завершающей запятой в списке, если он строчный;
Завершающие запятые в картах;
Не использовать вложенность селекторов, только для псевдоклассов и псевдоэлементов;
Именование через дефис;
Подробные комментарии;
SassDoc API для комментариев;
Ограниченное использование @extend;
Простые примеси;
Меньше циклов, насколько это возможно, без @while;
Уменьшенное число зависимостей;
Осмысленное использование ошибок и предупреждений.












