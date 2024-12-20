<?php include 'controller.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mi Tienda</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
            </ul>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light bg-light d-md-none">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCategories" aria-controls="navbarCategories" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCategories">
                <h4>Categorías</h4>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Categoría 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categoría 2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categoría 3</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <h4>Categorías</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Categoría 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Categoría 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Categoría 3</a>
                        </li>
                    </ul>
                </div>
            </nav>

           


            



            <main role="main" class="container mt-5">
                <div class="row">
                    <div class="col">
                        <button onclick="showAddProductDetails('Nombre', 'Descripción del producto .', '')">Añadir</button>
                    </div>
                </div>

                <div class="container">
                    <div class="row" id="product-list">
                    </div>
                </div>

               
            </main>
            
            <!-- Agregar al carrito -->
            <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel">Detalles del Producto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img id="modalImage" src="" alt="Producto" class="img-fluid">
                            <h5 id="modalTitle"></h5>
                            <p id="modalDescription"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Anadir producto -->
            <div class="modal fade" id="productAddModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="addProduct.php" method="POST" enctype="multipart/form-data"> 
                         <input type="hidden" name="global_token" value="<?php echo htmlspecialchars($_SESSION['global_token']); ?>">

                            <div class="modal-header">
                                <h1>Añadir Producto</h1>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li>
                                        <p>Nombre</p>
                                        <input type="text" name="name" required>
                                    </li>
                                    <li>
                                        <p>Slug</p>
                                        <input type="text" name="slug" required>
                                    </li>
                                    <li>
                                        <p>Descripción</p>
                                        <input type="text" name="description" required>
                                    </li>
                                    <li>
                                        <p>Features</p>
                                        <input type="text" name="features" required>
                                    </li>
                                    <li>
                                        <p>Imagen</p>
                                        <input type="file" name="image" accept="image/*" required>
                                    </li>
                                    <li>
                                        <p>Marca</p>
                                        <select name="brand_id" required>
                                            <option value="">Seleccione una marca</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Añadir</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



              <!-- Editar producto -->
            <div class="modal fade" id="productEditModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="editProduct.php" method="POST"> 
                            <input type="hidden" name="global_token" value="<?php echo htmlspecialchars($_SESSION['global_token']); ?>">

                            <div class="modal-header">
                                <h1>Editar Producto</h1>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li>
                                        <p>ID del Producto</p>
                                        <input type="hidden" name="product_id" id="editProductId" required>
                                    </li>
                                    <li>
                                        <p>Nombre</p>
                                        <input type="text" name="name" id="editProductName" required>
                                    </li>
                                    <li>
                                        <p>Slug</p>
                                        <input type="text" name="slug" id="editProductSlug" required>
                                    </li>
                                    <li>
                                        <p>Descripción</p>
                                        <input type="text" name="description" id="editProductDescription" required>
                                    </li>
                                    <li>
                                        <p>Features</p>
                                        <input type="text" name="features" id="editProductFeatures" required>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-footer">

                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




               <!-- Elimianar producto -->
               <div class="modal fade" id="productDeleteModal" tabindex="-1" role="dialog" aria-labelledby="productDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productDeleteModalLabel">Confirmar Eliminación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Está seguro de que desea eliminar este producto?</p>
                            <p><strong>ID del Producto: <span id="deleteProductId"></span></strong></p>
                            <p><strong>Nombre: <span id="deleteProductName"></span></strong></p>
                        </div>
                        <div class="modal-footer">
                            <form id="deleteProductForm" action="deleteProduct.php" method="POST">
                                <input type="hidden" name="global_token" value="<?php echo htmlspecialchars($_SESSION['global_token']); ?>">

                                <input type="hidden" name="product_id" id="deleteProductIdInput">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            






            <h2>Tabla de  Productos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Producto 1</td>
                        <td>Descripción del producto 1.</td>
                        <td>$10.00</td>
                        <td>
                            <button class="btn btn-primary" onclick="showProductDetails('Producto 1', 'Descripción del producto 1.', '')">Ver Detalles</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Producto 2</td>
                        <td>Descripción del producto 2.</td>
                        <td>$20.00</td>
                        <td>
                            <button class="btn btn-primary" onclick="showProductDetails('Producto 2', 'Descripción del producto 2.', '')">Ver Detalles</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Producto 3</td>
                        <td>Descripción del producto 3.</td>
                        <td>$30.00</td>
                        <td>
                            <button class="btn btn-primary" onclick="showProductDetails('Producto 3', 'Descripción del producto 3.', '')">Ver Detallees</button>
                        </td>
                    </tr>
                </tbody>
            </table>




            <!-- Modal de detalles productos -->
            <div class="modal fade" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productDetailsModalLabel">Detalles del Producto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img id="productImage" src="" alt="" class="img-fluid">
                            <h5 id="productName"></h5>
                            <p id="productDescription"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

          
 
            <script>
                function showProductDetails(title, description, image) {
                    document.getElementById('modalTitle').innerText = title;
                    document.getElementById('modalDescription').innerText = description;
                    document.getElementById('modalImage').src = image;
                    $('#productModal').modal('show'); 
                }


                function showAddProductDetails() {
                    console.log("sssssssssssss")
                    $('#productAddModal').modal('show'); 
                }

                function showEditProduct() {
                    
                    $('#productEditModal').modal('show'); 
                }

                function cargarMarcas() {
                    fetch('getBrands.php') 
                        .then(response => response.json())
                        .then(data => {
                            const select = document.querySelector('select[name="brand_id"]');
                            select.innerHTML = '<option value="">Seleccione una marca</option>'; 

                            if (data.error) {
                                console.error(data.error); 
                                return;
                            }

                            data.data.forEach(marca => {
                                const option = document.createElement('option');
                                option.value = marca.id;
                                option.textContent = marca.name;
                                select.appendChild(option); 
                            });
                        })
                        .catch(error => console.error('Error:', error));
                }

                window.onload = cargarMarcas;



                
                function showDetailsProduct(slug) {
                    fetch(`details.php?slug=${slug}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                document.getElementById('productImage').src = data.cover; 
                                document.getElementById('productName').textContent = data.name;
                                document.getElementById('productDescription').textContent = data.features;
                                
                                $('#productDetailsModal').modal('show');
                            }
                        })
                        .catch(error => {
                            console.error('Error al obtener los detalles del producto:', error);
                        });
                }

                function openEditModal(product) {
                    console.log(product); 
                    $('#editProductId').val(product.id);
                    $('#editProductName').val(product.name);
                    $('#editProductSlug').val(product.slug);
                    $('#editProductDescription').val(product.description);
                    $('#editProductFeatures').val(product.features);
                    
                    $('#productEditModal').modal('show');
                }

                function showEliminarProduct(productId, productName) {
                    const modal = $('#productDeleteModal');
                    
                    modal.find('#deleteProductId').text(productId);
                    modal.find('#deleteProductName').text(productName);
                    modal.find('#deleteProductIdInput').val(productId);
                    
                    modal.modal('show');
                }


            




                async function loadProducts() {
                    try {
                        const response = await fetch('controllerProductos.php'); 

                        if (!response.ok) {
                            throw new Error('Error en la red: ' + response.statusText);
                        }

                        const products = await response.json();
                        console.log(products); 

                        if (Array.isArray(products) && products.length > 0) {
                            const productList = document.getElementById('product-list');
                            productList.innerHTML = ''; 

                            products.forEach(product => {
                                const productCard = `
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <img src="${product.cover}" 
                                                class="card-img-top" 
                                                alt="Descripción de ${product.name}" 
                                                onerror="this.onerror=null; this.src='img.jpg';">

                                            <div class="card-body">
                                                <h5 class="card-title">${product.name}</h5>
                                                <p class="card-text">${product.description}</p>
                                                <a href="#" class="btn btn-primary" onclick="showProductDetails('${product.name}', 'Descripción no disponible.', '')">Agregar al carrito</a>
                                                <a href="#" class="btn btn-primary" onclick="showEditProduct(openEditModal({id: '${product.id}', name: '${product.name}', slug: '${product.slug}', description: '${product.description}', features: '${product.features}'}))">Editar</a>
                                                <a href="#" class="btn btn-primary" onclick="showDetailsProduct('${product.slug}')">Detalles</a>
                                                <a href="#" class="btn btn-primary" onclick="showEliminarProduct('${product.id}', '${product.name}')">Eliminar</a>

                                            </div>
                                        </div>
                                    </div>
                                `;
                                productList.innerHTML += productCard; 
                            });
                        } else {
                            console.log('No se encontraron productos.');
                        }
                    } catch (error) {
                        console.error('Error loading products:', error);
                    }
                }


                loadProducts(); 

            </script>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>