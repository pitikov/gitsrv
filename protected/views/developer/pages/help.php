<div class="doc"><h1>Справка</h1>
<h2>Доступ к репозиторию</h2>
<p class = "note">
Доступ к репозиториям проекта осуществляется посредством протокола ssh.<br/>
Формат строки доступа (имя репозитория):</p>
<p>&lsaquo;USER_NAME&rsaquo;@&lsaquo;SERVER_NAME&rsaquo;:/srv/git/&lsaquo;REPO_NAME&rsaquo;
</p>
<h2>Работа с GIT</h2>
<h3>Настройка Git клиента для идентификации пользователя:</h3>
<p class='code'>
git config --global user.name &quot;Your Name&quot;</p><p class='code'>
git config --global user.email &quot;your@email.address&quot;</p><p class='code'>
git config --global core.editor &quot;your editor&quot;
</p>
<h3>Работа с репозиториям</h3>
<p class='note'>
Инициализация репозитория в текущем каталоге:
</p><p class='code'>git init
</p><p class='note'>
Создает репозиторий в указанном каталоге:
</p><p class='code'>git init &lsaquo;directory&rsaquo;</p>
<p class='note'>
Клонирование репозитория на локальную машину:
</p><p class='code'>git clone &lsaquo;repo&rsaquo;
 </p><p class='note'>
Добавить файл для идексации и следить за всеми изменениями в нем ( можно задавать по маске ):
</p><p class='code'>git add &lsaquo;file&rsaquo;
</p><p class='note'>
Добавить каталог для индексации:
</p><p class='code'>git add &lsaquo;directory&rsaquo;
</p><p class='note'>
Удалить файл из индексации ( можно задавать по маске ):
</p><p class='code'>git rm &lsaquo;file&rsaquo;
</p><p class='note'>
Перенести или переименовать файл / каталог:
</p><p class='code'>git mv &lsaquo;source&rsaquo; &lsaquo;destination&rsaquo;
</p><p class='note'>
Сделать &quot;снапшот&quot; всех выполненных изменений:
</p><p class='code'>git commit -a -m &quot;message&quot;
</p><p class='note'>
Статус репозитория ( добавление, удаление, изменение файлов ):
</p><p class='code'>git status
</p><p class='note'>
Показать историю коммитов:
</p><p class='code'>git log
</p><p class='note'>
Показать только определенное количество коммитов:
</p><p class='code'>git log -n &lsaquo;limit&rsaquo;
</p><p class='note'>
Показать историю коммитов по конкретному файлу:
</p><p class='code'>git log &lsaquo;file&rsaquo;
</p><p class='note'>
Посмотреть различия между последним коммитом и текущими изменениями:
</p><p class='code'>git diff
</p><p class='note'>
Просмотр всех различий между коммитами:
</p><p class='code'>git diff &lsaquo;commit&rsaquo; &lsaquo;commit&rsaquo;
</p><p class='note'>
Посмотреть различия между коммитом и текущими изменениями:
</p><p class='code'>git diff &lsaquo;commit&rsaquo; &lsaquo;file&rsaquo;
</p><p class='note'>
Посмотреть различия между коммитами для файла:
</p><p class='code'>git diff &lsaquo;commit&rsaquo; &lsaquo;commit&rsaquo; &lsaquo;file&rsaquo;
</p><p class='note'>
Показать список всех файлов в основной ветке:
</p><p class='code'>git ls-tree master -r --name-only
</p>
<h3>Работа с ветками</h3>
<p class='note'>Список веток:
</p><p class='code'>git branch
</p><p class='note'>
Создание ветки:
</p><p class='code'>git branch &lsaquo;new_branch_name&rsaquo;
</p><p class='note'>
Безопастное удаление ветки, если не были сделаны изменения:
</p><p class='code'>git branch -d &lsaquo;branch_name&rsaquo;
</p><p class='note'>
Удаление ветки, даже если были сделаны изменения:
</p><p class='code'>git branch -D &lsaquo;branch_name&rsaquo;
</p><p class='note'>
Переименование текущей ветки:
</p><p class='code'>git branch -m &lsaquo;rename_current_branch&rsaquo;
</p><p class='note'>
Переход к существующей ветке:
</p><p class='code'>git checkout &lsaquo;branch_name&rsaquo;
</p><p class='note'>
Создание и переход к ветке:
</p><p class='code'>git checkout -b &lsaquo;new_branch_name&rsaquo;
</p><p class='note'>
Слияние текущей ветки с указанной:
</p><p class='code'>git merge &lsaquo;branch&rsaquo;
</p>
<h3>Откат изменений</h3>
<p class='note'>
Перейти на последний коммит ветки &quot;master&quot;:
</p><p class='code'>git checkout master
</p><p class='note'>
Откатить изменения во всех файлах до указанного коммита:
</p><p class='code'>git checkout &lsaquo;commit&rsaquo;
</p><p class='note'>
Откатить изменения для конкретного файла до указанного коммита:
</p><p class='code'>git checkout &lsaquo;commit&rsaquo; &lsaquo;file&rsaquo;
</p><p class='note'>
Сделать откат всех изменений выполненных в коммите, при этом создается новый коммит указывающий на откат изменений:
</p><p class='code'>git revert &lsaquo;commit&rsaquo;
</p><p class='note'>
Отмена изменений до последнего коммита, а также сбрасывает индексацию для конкретного файла:
</p><p class='code'>git reset HEAD &lsaquo;file&rsaquo;
 </p><p class='note'>
Отмена изменений до последнего коммита и сбрасывает индексацию:
</p><p class='code'>git reset --soft
</p><p class='note'>
Отмена изменений до последнего коммита, сбрасывает индексацию, а так же отменить любые изменения в рабочей директории:
</p><p class='code'>git reset --hard
</p><p class='note'>
Удаляет файлы которые не были добавлены в репозиторий:
</p><p class='code'>git clean -f
</p><p class='note'>
Удаляет файлы которые не были добавлены в репозиторий по указанному пути:
</p><p class='code'>git clean -f &lsaquo;path&rsaquo;
</p><p class='note'>
Удаляет файлы и каталоги которые не были добавлены в репозиторий:
</p><p class='code'>git clean -df
</p><p class='note'>
Только показывает, что будет удаленно:
</p><p class='code'>git clean -n
</p>
<h3>Работа с удаленными репозиториями</h3>
<p class='note'>
Список соединений с удаленными репозиториями:
</p><p class='code'>git remote
</p><p class='note'>
Добавить соединение:
</p><p class='code'>git remote add &lsaquo;name&rsaquo; &lsaquo;url&rsaquo;
</p><p class='note'>
Удалить соединение:
</p><p class='code'>git remote rm &lsaquo;name&rsaquo;
</p><p class='note'>
Переименовать соединение:
</p><p class='code'>git remote rename &lsaquo;old_name&rsaquo; &lsaquo;new_name&rsaquo;
</p><p class='note'>
Получить изменения из репозитория со списком всех веток ( при этом стираются любые локальные изменения ):
</p><p class='code'>git fetch &lsaquo;remote&rsaquo;
 </p><p class='note'>
Получить изменения из репозитория для конкретной ветки ( при этом стираются любые локальные изменения ):
</p><p class='code'>git fetch &lsaquo;remote&rsaquo; &lsaquo;branch&rsaquo;
</p><p class='note'>
Получить копию текущей ветки с удаленного репозитория и слить ее с локальной копией:
</p><p class='code'>git pull &lsaquo;remote&rsaquo;
</p><p class='note'>
Залить указанную ветку на удаленный репозиторий:
</p><p class='code'>git push &lsaquo;remote&rsaquo; &lsaquo;branch&rsaquo;
</p>
</div>