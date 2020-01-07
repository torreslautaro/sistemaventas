<template>
    
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Articulos
                        <button type="button" class="btn btn-secondary" @click="abrirModal('articulos','crear')">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarArticulos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Precio Venta</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- el comando :key es para indicar cual es la clave primaria del array que estoy recorriendo -->
                                <tr v-for="datos in arrayArticulos" :key="datos.id">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('articulos','actualizar',datos)">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="datos.condicion == 1">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarArticulo(datos.id)" >
                                          <i class="icon-trash"></i>
                                        </button>
                                        </template>
                                        <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activarArticulo(datos.id)" >
                                          <i class="icon-check"></i>
                                        </button>
                                        </template>
                                    </td>
                                        <td v-text="datos.codigo">Código</td>
                                        <td v-text="datos.nombre">Nombre</td>
                                        <td v-text="datos.nombre_categoria">Categoría</td>
                                        <td v-text="datos.precio_venta">Precio Venta</td>
                                        <td v-text="datos.stock">Stock</td>
                                        <td v-text="datos.descripcion">Descripción</td>
                                    <td>
                                        <div v-if="datos.condicion == 1">
                                             <span class="badge badge-success">Activo</span>
                                        </div>

                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                         </div>
                                       
                                    </td>
                                    
                                </tr>
                        
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulomodal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categorias</label>
                                    <div class="col-md-9">
                                       <select name="selectCategoria" id="" class="form-control" v-model="idcategoria">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="categorias in arrayCategoria" :key="categorias.id" :value="categorias.id" v-text="categorias.nombre"></option>
                                       </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Codigo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Codigo de barras">
                                        <barcode :value="codigo" :options="{format:'EAN-13'}">
                                            Generando Codigo de Barras..
                                        </barcode>
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="nombre" class="form-control" placeholder="Nombre del articulo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Precio de Venta</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="precio_venta" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Stock</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stock" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Descripcion del articulo">
                                    </div>
                                </div>
                                <div v-show="errorValidacion" class="form-group row">
                                <div v-for="error in mensajeErrorValidacion" :key="error" class=" col-md-3 alert alert-danger"  role="alert">
                            
                                <strong v-text="error"></strong>

                                </div>
                                 </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" class="btn btn-primary" v-if="tipoaccion == 1" @click="crearArticulo()">Guardar</button>
                            <button type="button" class="btn btn-primary" v-if="tipoaccion == 2" @click="actualizarArticulo()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            
        </main>
        <!-- /Fin del contenido principal -->
</template>

<script>
import VueBarcode from 'vue-barcode';
    export default {

        data(){
            return{
                articulo_id: 0,
                idcategoria: 0,
                nombre_categoria: '',
                codigo: '',
                nombre:'',
                precio_venta:0,
                stock:0, 
                descripcion: '',
                arrayArticulos: [
                ],
                modal:0,
                tipoaccion: 0,
                titulomodal: "",
                errorValidacion: 0,
                mensajeErrorValidacion : [],
                pagination : {
                'total' : 0  ,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' :  0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar: '',
                arrayCategoria: []
            }
        },
        
        components: {
            'barcode': VueBarcode
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },

            pagesNumber: function() {
                if(!this.pagination.to){ // si la pagina es diferente del ultimo elemento actual
                    return [];
                }

                var from = this.pagination.current_page - this.offset;

                if(from < 1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },  
        methods : {
            listarArticulos (page, buscar, criterio){
                let me = this;
                var url = '/articulos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // en la siguiente linea obtengo todo los datos que se envien al entrar en la url /categorias gestionada por el metodo index de mi controlador
                // en response se guardan toos los datos obtenidos
                axios.get(url).then(function (response) {
                    // guardo en el array los datos que obtengo , indicando que quiero obtener solo lo de data donde estan los valores
                    var respuesta = response.data;
                    me.arrayArticulos = respuesta.articulos.data;
                    me.pagination = respuesta.pagination;
                 })
                 .catch(function (error) {
                // handle error
                console.log(error);
                 })
                .then(function () {
                // always executed
                });

            },
            selectCategoria(){
                 let me = this;
                var url = '/categorias/selectcategoria' ;
                // en la siguiente linea obtengo todo los datos que se envien al entrar en la url /categorias gestionada por el metodo index de mi controlador
                // en response se guardan toos los datos obtenidos
                axios.get(url).then(function (response) {
                    // guardo en el array los datos que obtengo , indicando que quiero obtener solo lo de data donde estan los valores
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias;
                    
                    
                 })
                 .catch(function (error) {
                // handle error
                console.log(error);
                 })
                .then(function () {
                // always executed
                });
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;

                me.pagination.current_page = page;

                me.listarArticulos(page, buscar, criterio);
            },
            validarArticulo()
            {   this.errorValidacion = 0;
                this.mensajeErrorValidacion = [];

                if(this.idcategoria == 0) this.mensajeErrorValidacion.push("Debes seleccionar una categoria");
                if(!this.nombre)
                {
                    this.errorValidacion = 1;
                    this.mensajeErrorValidacion.push('El campo nombre no puede estar vacio!');
                }
                if(!this.stock) this.mensajeErrorValidacion.push("El campo stock no puede estar vacio!");
                if(!this.precio_venta) this.mensajeErrorValidacion.push('El campo precio de venta no puede estar vacio!');

                return this.errorValidacion;
            },
            abrirModal(modelo,accion,datos=[]){
                switch(modelo)
                {
                    case('articulos'):
                    {
                        switch(accion)
                        {
                            case ('crear'):
                            {
                               
                                this.modal= 1;
                                this.titulomodal = "Crear una nuevo Articulo";
                                this.idcategoria = 0;
                                this.nombre_categoria = "";
                                this.codigo = "";
                                this.nombre = "";
                                this.precio_venta = 0;
                                this.stock = 0;
                                this.descripcion = "";
                                this.tipoaccion = 1;
                                break;
                            }
                            case('actualizar'):
                            {
                                    //console.log(datos);
                                    this.modal = 1;
                                    this.titulomodal = "Editanto el articulo : "+datos['nombre'];
                                    this.tipoaccion = 2;
                                    this.articulo_id = datos['id'];
                                    this.idcategoria = datos['idcategoria'];
                                    this.codigo = datos['codigo'];
                                    this.nombre = datos['nombre'];
                                    this.precio_venta = datos['precio_venta'];
                                    this.stock = datos['stock'];
                                    this.descripcion = datos['descripcion'];
                                    break;
                            }
                        }
                    }
                    
                }
                this.selectCategoria();
            },
            cerrarModal()
            {
                this.modal = 0;
                this.titulomodal = "";
                this.idcategoria = 0;
                this.nombre_categoria = "";
                this.codigo = "";
                this.nombre = "";
                this.precio_venta = 0;
                this.stock = 0;
                this.descripcion = "";
                this.buscar = "";
            },

            crearArticulo(){

                if(this.validarArticulo()){
                    return;
                }
                let me = this;

                axios.post('/articulos/crear',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'precio_venta': this.precio_venta,
                    'stock': this.stock,
                    'descripcion': this.descripcion
                }).then(function (response) {

                    me.cerrarModal();
                    me.listarArticulos(1,'','nombre');

                })

                .catch(function (error) {
                    console.log()
                     console.log(error.response);
                 })
            },
            actualizarArticulo(){
                if(this.validarArticulo()){
                    return;
                }
                let me = this;
                axios.put('/articulos/actualizar',{
                    'id' : this.articulo_id,
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'precio_venta': this.precio_venta,
                    'stock': this.stock,
                    'descripcion': this.descripcion
                }).then(function(responde){
                     me.cerrarModal();
                    me.listarArticulos(1,'','nombre');
                }).catch(function (error) {
                     console.log(error);
                 })
            },
            desactivarArticulo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Desea desactivar el Articulo?',
                text: "No podra revertir este cambio",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, desactivar!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/articulos/desactivar',{
                        'id' : id,
                    }).then(function(responde){
                            
                        me.listarArticulos(1,'','nombre');
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'El registro fue desactivado con exito.',
                        'success'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    })
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                    )
                }
                })
            },
            activarArticulo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Desea activar el articulo?',
                text: "No podra revertir este cambio",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, activar!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/articulos/activar',{
                        'id' : id,
                    }).then(function(responde){
                            
                        me.listarArticulos(1,'','nombre');
                        swalWithBootstrapButtons(
                        'Activado!',
                        'El registro fue activado con exito.',
                        'success'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    })
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                    )
                }
                })
            }

            
        },
        mounted() {
            //console.log('Component mounted.')
            this.listarArticulos(1,this.buscar,this.criterio);
        }
    }
</script>
<style>

    .modal-content
    {
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar
    {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }


</style>