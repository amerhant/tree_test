INSTALLATION
------------

- composer install
- создать пустую базу данных и настроить config/db.php под нее.
- chmod -R 777 runtime/
- chmod -R 777 web/assets/
- php yii migrate

USING
-----

- /site/index - вывести дерево (очень схематично если нужно могу доработать)
- /site/seeder - заполнить бинар до 5 уровня
- /site/get-down-items?id=  получить по id ячейки все нижестоящие ячейки.
- /site/get-up-items?id=  получить по id ячейки все вышестоящие ячейки.

По сути, весь функционал находится в модели Tree.php 
<br>
Ради одной функции создания ячейки я не стал создавать еще один класс.