<!DOCTYPE html>
<html>
<head>
    <title>Your Page</title>
</head>
<style>
    body {
        background: #c6ece6;
    }

    table {
        width: 100%;
    }

    tr {
        background: white;
        height: 50px;
        text-align: center;
    }

    .add {
        position: relative;
        width: 100%;
        height: 100px;
    }

    #open-modal-add {
        background: aqua;
        width: 200px;
        height: 50px;
        position: absolute;
        top: 40px;
        right: 0;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    /* Стили для формы */
    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    label {
        font-weight: bold;
    }

    input, select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-top: 4px;
    }

    button[type="button"] {
        background-color: #497070;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .attribute-field {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .attribute-field input {
        flex: 1;
    }

    #login-modal {
        display: none;
        position: fixed;
        z-index: 2;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        background-color: #fefefe;
        padding: 20px;
        border: 1px solid #888;
        width: 500px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    #overlay {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
    }
    #login-modal input {
        margin-top: 8px;
    }
</style>
<body>
<div class="add">
    <button id="open-modal-add" onclick="openModal()">Добавить</button>
</div>
<table border="1">
    <thead>
    <tr>
        <th>Артикул</th>
        <th>Название</th>
        <th>Статус</th>
        <th>Атрибуты</th>
        <th>Операция</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->article }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->status }}</td>
            <td>
                @foreach($product->data as $data)
                    @if(isset($data['size']) && isset($data['color']))
                        SIZE: {{ $data['size'] ?: [] }}
                        COLOR: {{ $data['color'] ?: []}}
                        <hr>
                    @endif
                @endforeach
            </td>
            <td>
                <button style="background: red; width: 100px; height: 50px" data-id="{{ $product->id }}"
                        onclick="deleteProduct(this)">Удалить
                </button>
                <button style="background: yellow; width: 100px; height: 50px" data-id="{{ $product->id }}"
                        onclick="editProduct(this)">Редактировать
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <!-- Здесь разместите форму для добавления продукта -->
        <form id="productForm">
            <!-- Ваши поля для добавления продукта -->
            <label for="article">Артикул:</label>
            <input type="text" id="article" name="article" required><br>

            <label for="name">Название:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="status">Статус:</label>
            <select name="status" id="status">
                <option value="available">available</option>
                <option value="unavailable">unavailable</option>
            </select>

            <div id="attributesContainer">
                <label>Атрибуты:</label>
                <div id="attributeFields"></div>
                <button type="button" onclick="addAttributeField()">Добавить атрибут</button>
            </div>

            <button type="button" onclick="addProduct()">Добавить продукт</button>
        </form>
    </div>
</div>
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <form id="editProductForm">
            <input type="hidden" id="editProductId" name="id">
            <label for="editArticle">Артикул:</label>
            <input type="text" id="editArticle" name="article" required><br>

            <label for="editName">Название:</label>
            <input type="text" id="editName" name="name" required><br>

            <label for="editStatus">Статус:</label>
            <select name="status" id="editStatus">
                <option value="available">available</option>
                <option value="unavailable">unavailable</option>
            </select>

            <div id="editAttributesContainer">
                <label>Атрибуты:</label>
                <div id="editAttributeFields"></div>
                <button type="button" onclick="addEditAttributeField()">Добавить атрибут</button>
            </div>

            <button id="updateProductButton" type="button" onclick="updateProduct()">Сохранить</button>
        </form>
    </div>
</div>

<div id="overlay"></div>
<div id="login-modal">
    <h2>Login</h2>
    <form id="loginForm" onsubmit="login(event)">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        checkToken();
    });
    function checkToken() {
        var token = localStorage.getItem('token');
        if (!token) {
            // Если токена нет, открываем попап с формой авторизации
            openLoginModal();
            $('#overlay').show();
        }
    }

    function closeOverlay() {
        $('#overlay').hide();
    }

    function openLoginModal() {
        document.getElementById('login-modal').style.display = 'block';
    }

    function closeLoginModal() {
        document.getElementById('login-modal').style.display = 'none';
        closeOverlay();
    }

    function login(event) {
        event.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            url: 'http://localhost/api/login',
            type: 'POST',
            data: {email: email, password: password},
            success: function (data) {
                localStorage.setItem('token', data.token);

                closeLoginModal();
            },
            error: function (error) {
                console.error('Login Error:', error);
                // Обработка ошибок
            }
        });
    }


    function addEditAttributeField(size = '', color = '') {
        var editAttributesContainer = document.getElementById('editAttributeFields');
        var editAttributeField = document.createElement('div');
        editAttributeField.classList.add('attribute-field');

        var editNameInput = document.createElement('input');
        editNameInput.type = 'text';
        editNameInput.placeholder = 'Название';
        editNameInput.value = size;

        var editValueInput = document.createElement('input');
        editValueInput.type = 'text';
        editValueInput.placeholder = 'Значение';
        editValueInput.value = color;

        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.textContent = 'Удалить';
        deleteButton.onclick = function () {
            editAttributesContainer.removeChild(editAttributeField);
        };

        editAttributeField.appendChild(editNameInput);
        editAttributeField.appendChild(editValueInput);
        editAttributeField.appendChild(deleteButton);

        editAttributesContainer.appendChild(editAttributeField);
    }

    function editProduct(button) {
        var productId = $(button).data('id');

        $.ajax({
            url: 'http://localhost/api/products/' + productId,
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            success: function (data) {

                $('#editArticle').val(data.article);
                $('#editName').val(data.name);
                $('#editStatus').val(data.status);
                $('#editAttributeFields').empty();
                $('#updateProductButton').attr('data-id', data.id)
                data.data.forEach(function (attribute) {
                    addEditAttributeField(attribute.size, attribute.color);
                });

                openEditModal();
            },
            error: function (error) {
                if (error.status === 401){
                    localStorage.removeItem('token')
                    location.reload()
                }
            }
        });
    }

    function updateProduct() {
        var productId = $('#updateProductButton').attr('data-id');

        var article = $('#editArticle').val();
        var name = $('#editName').val();
        var status = $('#editStatus').val();


        var attributes = [];

        $('.attribute-field').each(function () {
            var attributeName = $(this).find('input[placeholder="Название"]').val();
            var attributeValue = $(this).find('input[placeholder="Значение"]').val();
            attributes.push({size: attributeName, color: attributeValue});
        });
        var productData = {
            article: article,
            name: name,
            status: status,
            data: attributes
        };

        $.ajax({
            url: 'http://localhost/api/products/' + productId,
            type: 'PATCH',
            data: JSON.stringify(productData),
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            success: function (data) {
                alert('Product success updated');
            },
            error: function (error) {
                if (error.status === 401){
                    localStorage.removeItem('token')
                    location.reload()
                }
            }
        });
    }

    function deleteProduct(button) {
        var productId = $(button).data('id');

        $.ajax({
            url: 'http://localhost/api/products/' + productId,
            type: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            success: function (data) {
                alert('Продукт успешно удален!');
            },
            error: function (error) {
                if (error.status === 401){
                    localStorage.removeItem('token')
                    location.reload()
                }
            }
        });
    }

    function addProduct() {
        var article = $('#article').val();
        var name = $('#name').val();
        var status = $('#status').val();

        var attributes = [];

        $('.attribute-field').each(function () {
            var attributeName = $(this).find('input[placeholder="Название"]').val();
            var attributeValue = $(this).find('input[placeholder="Значение"]').val();
            attributes.push({size: attributeName, color: attributeValue});
        });

        var productData = {
            article: article,
            name: name,
            status: status,
            data: attributes
        };

        $.ajax({
            url: 'http://localhost/api/products',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(productData),
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            success: function (data) {
                $('#myModal').css('display', 'none');
            },
            error: function (error) {
                var errorData = JSON.parse(error.responseText);
                var errorMessage = "Errors:\n";

                for (var field in errorData.errors) {
                    errorMessage += field + ": " + errorData.errors[field][0] + "\n";
                }
                alert(errorMessage);
            }
        });
    }
</script>
<script>
    function addAttributeField() {
        var attributesContainer = document.getElementById('attributeFields');
        var attributeField = document.createElement('div');
        attributeField.classList.add('attribute-field');

        var nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.placeholder = 'Название';

        var valueInput = document.createElement('input');
        valueInput.type = 'text';
        valueInput.placeholder = 'Значение';

        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.textContent = 'Удалить';
        deleteButton.onclick = function () {
            attributesContainer.removeChild(attributeField);
        };

        attributeField.appendChild(nameInput);
        attributeField.appendChild(valueInput);
        attributeField.appendChild(deleteButton);

        attributesContainer.appendChild(attributeField);
    }


    function openEditModal() {
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function openModal() {
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }
</script>
</body>
</html>
