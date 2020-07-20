<section>
	<div class="container">
		<div class="row">
			<div class="col-12" style="margin-top: 40px">
				<h4 class="text-center">
					Тестовое задание для PHP-разработчика
				</h4>
				<ul class="list-unstyled" style="margin-top: 40px">
					<li>
						1. Реализовать сущности авторы и книги
					</li>
					<li>
						2. Реализовать административную часть
						<ol>
							a. CRUD операции для авторов и книг
						</ol>
						<ol>
							b. вывести список книг с обязательным указанием имени автора в списке
						</ol>
						<ol>
							c. вывести список авторов с указанием кол-ва книг
						</ol>
					</li>
					<li>
						3. Реализовать публичную часть сайта с отображение авторов и их книг (простой вывод списка на странице). Дизайн не важен, bootstrap подойдет для решения.
					</li>
					<li>
						4. Реализовать выдачу данных в формате json по RESTful протоколу отдельным контроллером
						<ol>
							a. GET /api/v1/books/list получение списка книг с именем автора
						</ol>
						<ol>
							b. GET /api/v1/books/by-id получение данных книги по id
						</ol>
						<ol>
							c. POST /api/v1/books/update обновление данных книги
						</ol>
						<ol>
							d. DELETE /api/v1/books/id удаление записи книги из бд
						</ol>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>