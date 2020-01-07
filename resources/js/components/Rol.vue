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
                        <i class="fa fa-align-justify"></i> Roles
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarRol(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarRol(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                            <vue-wysiwyg></vue-wysiwyg>
                        </div>
                        <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- el comando :key es para indicar cual es la clave primaria del array que estoy recorriendo -->
                                <tr v-for="datos in arrayRol" :key="datos.id">
                                    <td v-text="datos.nombre"></td>
                                    <td v-text ="datos.descripcion"></td>
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
    </main>
</template>

<script>
    export default {

        data(){
            return{
                rol_id: 0,
                nombre:'',
                descripcion: '',
                arrayRol: [
                ],
                modal:0,
                tipoaccion: 0,
                titulomodal: "",
                errorValidacion: 0,
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
            listarRol (page, buscar, criterio){
                let me = this;
                var url = '/rol?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // en la siguiente linea obtengo todo los datos que se envien al entrar en la url /categorias gestionada por el metodo index de mi controlador
                // en response se guardan toos los datos obtenidos
                axios.get(url).then(function (response) {
                    // guardo en el array los datos que obtengo , indicando que quiero obtener solo lo de data donde estan los valores
                    var respuesta = response.data;
                    me.arrayRol = respuesta.roles.data;
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

                me.listarRol(page, buscar, criterio);
            }
            
        },
        mounted() {
            //console.log('Component mounted.')
            this.listarRol(1,this.buscar,this.criterio);
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