<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación PHP + MySQL</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .form-section h2 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .users-section h2 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        .users-list {
            list-style: none;
        }
        .user-item {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            transition: transform 0.2s;
        }
        .user-item:hover {
            transform: translateX(5px);
        }
        .user-name {
            font-weight: bold;
            color: #333;
            font-size: 1.1em;
        }
        .user-email {
            color: #666;
            margin-top: 5px;
        }
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .loading {
            text-align: center;
            color: #666;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐳 Docker PHP + MySQL</h1>
            <p>Gestión de Usuarios</p>
        </div>
        
        <div class="content">
            <!-- Formulario para agregar usuario -->
            <div class="form-section">
                <h2>➕ Agregar Nuevo Usuario</h2>
                <form id="addUserForm">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <button type="submit">Agregar Usuario</button>
                </form>
                <div id="message"></div>
            </div>

            <!-- Lista de usuarios -->
            <div class="users-section">
                <h2>👥 Lista de Usuarios</h2>
                <div id="usersList" class="loading">Cargando usuarios...</div>
            </div>
        </div>
    </div>

    <script>
        // Cargar usuarios al iniciar
        loadUsers();

        // Manejar envío del formulario
        document.getElementById('addUserForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const messageDiv = document.getElementById('message');
            
            try {
                const response = await fetch('/users.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    messageDiv.innerHTML = '<div class="message success">✓ Usuario agregado exitosamente</div>';
                    e.target.reset();
                    loadUsers();
                    
                    setTimeout(() => {
                        messageDiv.innerHTML = '';
                    }, 3000);
                } else {
                    messageDiv.innerHTML = `<div class="message error">✗ Error: ${result.message}</div>`;
                }
            } catch (error) {
                messageDiv.innerHTML = '<div class="message error">✗ Error al agregar usuario</div>';
            }
        });

        // Función para cargar usuarios
        async function loadUsers() {
            const usersListDiv = document.getElementById('usersList');
            
            try {
                const response = await fetch('/users.php');
                const result = await response.json();
                
                if (result.success && result.data.length > 0) {
                    const usersHTML = result.data.map(user => `
                        <div class="user-item">
                            <div class="user-name">${escapeHtml(user.nombre)}</div>
                            <div class="user-email">📧 ${escapeHtml(user.email)}</div>
                        </div>
                    `).join('');
                    
                    usersListDiv.innerHTML = `<ul class="users-list">${usersHTML}</ul>`;
                } else if (result.success && result.data.length === 0) {
                    usersListDiv.innerHTML = '<p style="text-align: center; color: #666;">No hay usuarios registrados</p>';
                } else {
                    usersListDiv.innerHTML = '<p style="text-align: center; color: #d32f2f;">Error al cargar usuarios</p>';
                }
            } catch (error) {
                usersListDiv.innerHTML = '<p style="text-align: center; color: #d32f2f;">Error de conexión</p>';
            }
        }

        // Función para escapar HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
