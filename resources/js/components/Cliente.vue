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
                        <i class="fa fa-align-justify"></i> Clientes
                        <button type="button" class="btn btn-secondary" @click="abrirModal('clientes','crear')">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="num_documento">Documento</option>
                                      <option value="email">Email</option>
                                      <option value="telefono">Telefono</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.40="listarClientes(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarClientes(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Tipo de Documento</th>
                                    <th>Numero de Documento</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                            <!-- el comando :key es para indicar cual es la clave primaria del array que estoy recorriendo -->
                                <tr v-for="datos in arrayClientes" :key="datos.id">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('clientes','actualizar',datos)">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        
                                    </td>
                                    <td v-text="datos.nombre"></td>
                                    <td v-text ="datos.tipo_documento"></td>
                                    <td v-text ="datos.num_documento"></td>
                                    <td v-text ="datos.direccion"></td>
                                    <td v-text ="datos.telefono"></td>
                                    <td v-text ="datos.email"></td> 
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model ="nombre" class="form-control" placeholder="Nombre de categoría">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo de Documento</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="tipo_documento" class="form-control" placeholder="Tipo Doc">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Numero de documento</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="num_documento" class="form-control" placeholder="Numero de documento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Tipee su direccion.">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="telefono" class="form-control" placeholder="Ingrese su numero de telefono.">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="Ingrese su email">
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
                            <button type="button" class="btn btn-primary" v-if="tipoaccion == 1" @click="crearCliente()">Guardar</button>
                            <button type="button" class="btn btn-primary" v-if="tipoaccion == 2" @click="actualizarClientes()">Actualizar</button>
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
                cliente_id: 0,
                nombre:'',
                tipo_documento: 'DNI',
                num_documento: '',
                direccion: '',
                telefono: '',
                email: '', 
                arrayClientes: [
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
            listarClientes (page, buscar, criterio){
                let me = this;
                var url = '/clientes?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // en la siguiente linea obtengo todo los datos que se envien al entrar en la url /categorias gestionada por el metodo index de mi controlador
                // en response se guardan toos los datos obtenidos
                axios.get(url).then(function (response) {
                    // guardo en el array los datos que obtengo , indicando que quiero obtener solo lo de data donde estan los valores
                    var respuesta = response.data;
                    me.arrayClientes = respuesta.personas.data;
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

                me.listarClientes(page, buscar, criterio);
            },
            validarClientes()
            {   this.errorValidacion = 0;
                this.mensajeErrorValidacion = [];
                if(!this.nombre)
                {
                    this.errorValidacion = 1;
                    this.mensajeErrorValidacion.push('El campo nombre no puede estar vacio!');
                }
                if(!this.tipo_documento) this.mensajeErrorValidacion.push('El campo tipo de documento no puede estar vacio');
                if(!this.num_documento) this.mensajeErrorValidacion.push('El campo numero de documento no puede estar vacio');
                return this.errorValidacion;
            },
            abrirModal(modelo,accion,datos=[]){
                switch(modelo)
                {
                    case('clientes'):
                    {
                        switch(accion)
                        {
                            case ('crear'):
                            {
                               
                                this.modal= 1;
                                this.titulomodal = "Dar de alta un nuevo cliente";
                                this.tipoaccion = 1;
                                this.nombre = "";
                                this.tipo_documento = "";
                                this.num_documento = "";
                                this.direccion = "";
                                this.telefono = "";
                                this.email = "";
                                this.buscar = "";
                                break;
                            }
                            case('actualizar'):
                            {
                                    //console.log(datos);
                                    this.modal = 1;
                                    this.titulomodal = "Editanto la categoria : "+datos['nombre'];
                                    this.tipoaccion = 2;
                                    this.cliente_id = datos['id'];
                                    this.nombre = datos['nombre'];
                                    this.tipo_documento = datos['tipo_documento'];
                                    this.num_documento = datos['num_documento'];
                                    this.direccion = datos['direccion'];
                                    this.telefono = datos['telefono'];
                                    this.email = datos['email'];
                                    this.buscar = datos['buscar'];
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
                this.tipo_documento = "";
                this.num_documento = "";
                this.direccion = "";
                this.telefono = "";
                this.email = "";
                this.buscar = "";
            },

            crearCliente(){

                if(this.validarClientes()){
                    return;
                }
                let me = this;

                axios.post('/clientes/crear',{
                    'nombre' : this.nombre,
                    'tipo_documento' : this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'email': this.email
                }).then(function (response) {

                    me.cerrarModal();
                    me.listarClientes(1,'','nombre');

                })

                .catch(function (error) {
                     console.log(error);
                 })
            },
            actualizarClientes(){
                if(this.validarClientes()){
                    return;
                }
                let me = this;
                axios.put('/clientes/actualizar',{
                    'id' : this.cliente_id,
                    'nombre' : this.nombre,
                    'tipo_documento' : this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'email': this.email
                }).then(function(response){
                     me.cerrarModal();
                    me.listarClientes(1,'','nombre');
                }).catch(function (error) {
                     console.log(error);
                 })
            }
    
        },
        mounted() {
            //console.log('Component mounted.')
            this.listarClientes(1,this.buscar,this.criterio);
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