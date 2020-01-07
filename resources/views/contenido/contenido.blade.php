@extends('principal')
@section('contenido')
    <template v-if="menu == 0">
    
        <h1>Estas en el menu 0</h1>

    </template>

    <template v-if="menu == 1">
    
        <categorias></categorias>

    </template>

    <template v-if="menu == 2">
    
    <articulos></articulos>

    </template>

    <template v-if="menu == 3">
    
    <h1>Estas en el menu 3</h1>

    </template>

    <template v-if="menu == 4">

        <prueba></prueba>

    </template>

    <template v-if="menu == 5">

    <h1>Estas en el menu 5</h1>

    </template>

    <template v-if="menu == 6">

    <clientes> </clientes>

    </template>

    <template v-if="menu == 7">

    <h1>Estas en el menu 7</h1>

    </template>

    <template v-if="menu == 8">

    <roles></roles>

    </template>

    <template v-if="menu == 9">

    <h1>Estas en el menu 9</h1>

    </template>

    <template v-if="menu == 10">

    <h1>Estas en el menu 10</h1>

    </template>

    <template v-if="menu == 11">

    <mail-component></mail-component>

    </template>

    <template v-if="menu == 12">

    <h1>Estas en el menu 12</h1>

    </template> 
    
@endsection