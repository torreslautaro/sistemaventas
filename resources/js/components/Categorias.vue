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
                        <i class="fa fa-align-justify"></i> Categorías
                        <button type="button" class="btn btn-secondary" @click="abrirModal('categorias','crear')">
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
                                    <input type="text" v-model="buscar" @keyup.enter="listarCategoria(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarCategoria(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                            <vue-wysiwyg></vue-wysiwyg>
                        </div>
                        <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- el comando :key es para indicar cual es la clave primaria del array que estoy recorriendo -->
                                <tr v-for="datos in arrayCategorias" :key="datos.id">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('categorias','actualizar',datos)">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="datos.condicion == 1">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarCategoria(datos.id)" >
                                          <i class="icon-trash"></i>
                                        </button>
                                        </template>
                                        <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activarCategoria(datos.id)" >
                                          <i class="icon-check"></i>
                                        </button>
                                        </template>
                                    </td>
                                    <td v-text="datos.nombre"></td>
                                    <td v-text = "datos.descripcion"></td>
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
                        </div>
                      
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model = "nombre" class="form-control" placeholder="Nombre de categoría">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Descripción de la categoria">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div v-show="errorValidacion" class="form-group row">
                        <div v-for="error in mensajeErrorValidacion" :key="error" class=" col-md-3 alert alert-danger"  role="alert">
                            
                            <strong v-text="error"></strong>

                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" class="btn btn-primary" v-if="tipoaccion == 1" @click="crearCategoria()">Guardar</button>
                            <button type="button" class="btn btn-primary" v-if="tipoaccion == 2" @click="actualizarCategoria()">Actualizar</button>
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
    export default {

        data(){
            return{
                categoria_id: 0,
                nombre:'',
                descripcion: '',
                arrayCategorias: [
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
                buscar: ''
            }
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
            listarCategoria (page, buscar, criterio){
                let me = this;
                var url = '/categorias?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // en la siguiente linea obtengo todo los datos que se envien al entrar en la url /categorias gestionada por el metodo index de mi controlador
                // en response se guardan toos los datos obtenidos
                axios.get(url).then(function (response) {
                    // guardo en el array los datos que obtengo , indicando que quiero obtener solo lo de data donde estan los valores
                    var respuesta = response.data;
                    me.arrayCategorias = respuesta.categorias.data;
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
            cambiarPagina(page, buscar, criterio){
                let me = this;

                me.pagination.current_page = page;

                me.listarCategoria(page, buscar, criterio);
            },
            validarCategoria()
            {   this.errorValidacion = 0;
                this.mensajeErrorValidacion = [];
                if(!this.nombre)
                {
                    this.errorValidacion = 1;
                    this.mensajeErrorValidacion.push('El campo nombre no puede estar vacio!');
                }

                return this.errorValidacion;
            },
            abrirModal(modelo,accion,datos=[]){
                switch(modelo)
                {
                    case('categorias'):
                    {
                        switch(accion)
                        {
                            case ('crear'):
                            {
                               
                                this.modal= 1;
                                this.titulomodal = "Crear una nueva Categoria";
                                this.tipoaccion = 1;
                                this.nombre = "";
                                this.descripcion = "";
                                break;
                            }
                            case('actualizar'):
                            {
                                    //console.log(datos);
                                    this.modal = 1;
                                    this.titulomodal = "Editanto la categoria : "+datos['nombre'];
                                    this.tipoaccion = 2;
                                    this.categoria_id = datos['id'];
                                    this.nombre = datos['nombre'];
                                    this.descripcion = datos['descripcion'];
                                    break;
                            }
                        }
                    }
                }
            },
            cerrarModal()
            {
                this.modal = 0;
                this.titulomodal = "";
                this.nombre = "";
                this.descripcion = "";
                this.buscar = "";
            },

            crearCategoria(){

                if(this.validarCategoria()){
                    return;
                }
                let me = this;

                axios.post('/categorias/crear',{
                    'nombre' : this.nombre,
                    'descripcion' : this.descripcion
                }).then(function (response) {

                    me.cerrarModal();
                    me.listarCategoria(1,'','nombre');

                })

                .catch(function (error) {
                     console.log(error);
                 })
            },
            actualizarCategoria(){
                if(this.validarCategoria()){
                    return;
                }
                let me = this;
                axios.put('/categorias/actualizar',{
                    'id' : this.categoria_id,
                    'nombre' : this.nombre,
                    'descripcion' : this.descripcion
                }).then(function(responde){
                     me.cerrarModal();
                    me.listarCategoria(1,'','nombre');
                }).catch(function (error) {
                     console.log(error);
                 })
            },
            desactivarCategoria(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Desea desactivar la categoria?',
                text: "No podra revertir este cambio",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, desactivar!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/categorias/desactivar',{
                        'id' : id,
                    }).then(function(responde){
                            
                        me.listarCategoria(1,'','nombre');
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
            activarCategoria(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Desea activar la categoria?',
                text: "No podra revertir este cambio",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, activar!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/categorias/activar',{
                        'id' : id,
                    }).then(function(responde){
                            
                        me.listarCategoria(1,'','nombre');
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
            this.listarCategoria(1,this.buscar,this.criterio);
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