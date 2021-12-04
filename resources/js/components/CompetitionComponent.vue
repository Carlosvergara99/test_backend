<template>
 
    <div>
        <section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">PRUEBA TÉCNICA DESARROLLADOR BACKEND </h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
							<div class="text w-100">
								<h2>Sortear Premio</h2>
								<p>Solo para usuarios registrados</p>
								<a href="#" class="btn btn-white btn-outline-white" @click="Sorting()"> ¡Sortear!</a>
							</div>
			      </div>
				<div class="login-wrap p-4 p-lg-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Registrate para participar en el sorteo</h3>
			      		</div>
                      <div class="w-50">
									    <p class="social-media d-flex justify-content-end">
									  	<a @click="download()" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-arrow-circle-down"></span></a>
									</p>
								</div>
							
			      	</div>
							<form  class="signin-form"  @submit.prevent="Add()" >
                        <div class="form-group mb-3">
			      			     <label class="label" for="name">Nombre:</label>
			      		      	   <input type="text" class="form-control" placeholder="Nombre" v-model="data.name">
			      		         </div>

                                <div class="form-group mb-3">
                                 <label class="label" for="name">Apellido:</label>
			      		      	   <input type="text" class="form-control" placeholder="Apellido" v-model="data.last_name">
			      		         </div>

                                <div class="form-group mb-3">
                                <label class="label" for="name">Correo Electrónico:</label>
			      		      	   <input type="email" class="form-control" placeholder="Email" v-model="data.email">
                                    <p class="text-danger" v-text="errors.email"></p>

			      		         </div>
                                   	<div class="form-row">
										<div class="col">
                                            <label for="label" >Celular:</label>

										  <input type="number" class="form-control" placeholder="# celuluar" v-model="data.phone">
                                            <p class="text-danger" v-text="errors.phone"></p>

										</div>
										<div class="col">
                                            <label for="label" >Cédula</label>
										    <input type="number" class="form-control" placeholder="CC" v-model="data.cc">
										    <p class="text-danger" v-text="errors.cc"></p>

										</div>
									  </div>
                                      
									<div class="form-row">
									  <div class="col">
                                        <label for="label" >Departamento</label>
                                        <select name="" id=""  class="form-control" v-model="data.department"  @change="getCities()" >
                                            <option value="">Seleccione</option>
											<option v-for="item in departments " :key="item.id">{{item.departamento}}</option>
										 </select>  
									  </div>
									  <div class="col">
                                        <label for="label" >Ciudad</label>
                                         <select name="" id=""  class="form-control" v-model="data.city">
                                            <option value="">Seleccione</option>

											<option v-for="item in cities " :key="item.id">{{item.municipio}}</option>

										 </select>  
									  </div>
									</div>
									
								
									<br>
                         <div class="form-group d-md-flex">
		            	<div class="w-10">
			            	<label class="checkbox-wrap checkbox-primary mb-0"  >
									  <input type="checkbox" class="form-check-input" id="exampleCheck1"  v-model="data.habeas" >
									  <span class="checkmark"></span>
										</label> 

									</div>
                                    <div class="w-10 w-50 text-md-left ">
									  <a >Habeas Data<span class="btn-link" @click="habeasData()"> Haga clic</span></a>
									</div>
									
		            </div>
		            <div class="form-group">
		            	<button type="submit" class="form-control btn btn-primary submit px-3"> Registrar</button>
		            </div>
		            
		          </form>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>
    </div>
</template>

<script>
    export default {
          data() {
            return {
                data: {
                    name:'',
                    last_name:'',
                    email:'',
                    cc:'',
                    phone:'',
                    department:'',
                    city:'',
                    habeas : false,
                },
                 departments:[],
                 cities:[],
                  errors: {}

            }
          },
        mounted() {
           this.getDepartments();
        },
        methods:{
          
           download(){
              axios.get('api/users/export',{responseType: 'arraybuffer'}).then((response) => {
                   var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                  var fileLink = document.createElement('a');
                   fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'users.xlsx');
                    document.body.appendChild(fileLink);
                    fileLink.click();

                 }).catch((errors) => {

                 })
           },
            Sorting(){
                axios.get('api/sorting').then((response) => {
                   toast.fire({
                    icon: 'success',
                    title: 'El ganador es..',
                    text:  response.data.name+" "+response.data.last_name+" con número cédula: "+ response.data.cc  
                 })

                 }).catch((errors) => {
                        if (errors.response.status == 404) {
                            toast.fire({
                                   icon: 'error',
                                  title: 'Para el generar el sorteo se debe registar al menos 5 usuarios',
                             })
                        }

                 })
            },
          Add(){ 
              const pattern = new RegExp('^[A-Z]+$', 'i');

              if (!this.data.habeas) {
                  toast.fire({
                    icon: 'error',title: 'el campo Habeas Data es obligatorio'
                   })
                  
              } else if ( this.data.name == '' || /[^A-Za-z\d]/.test(this.data.name) || !pattern.test(this.data.name)){

                    toast.fire({
                    icon: 'error',title: 'el campo nombre es obligatorio y valido'
                   })

              }else if (this.data.last_name == '' || /[^A-Za-z\d]/.test(this.data.last_name) || !pattern.test(this.data.last_name )){

                   toast.fire({
                    icon: 'error',title: 'el campo apellido  es obligatorio y valido'
                   })


              }else if (this.data.email == ''){  

                    toast.fire({
                    icon: 'error',title: 'el campo Email es obligatorio'
                   })
 
              }else if (!Number.parseInt(this.data.cc) ){

                    toast.fire({
                    icon: 'error',title: 'el campo cedula es obligatorio y debe ser numerico'
                   })

              }else if ( !Number.parseInt(this.data.phone) ||  this.data.phone.length > 10 || this.data.phone.length <10){

                    toast.fire({
                    icon: 'error',title: 'el campo celular es obligatorio y debe ser de 10 digitos '
                   })

              }else if (this.data.department == ''){

                   toast.fire({
                    icon: 'error',title: 'el campo Departamento es obligatorio'
                   })


              }else if (this.data.city == ''){

                    toast.fire({
                    icon: 'error',title: 'el campo Ciudad es obligatorio'
                   })

              }else {
               axios.post('api/register',this.data).then((response) => {
                   toast.fire({
                    icon: 'success',title: 'Información se ha registrado Correctamente'
                   })
                 this.data ={
                    name:'',
                    last_name:'',
                    email:'',
                    cc:'',
                    phone:'',
                    department:'',
                    city:'',
                    habeas : false
            }
            
                 this.cities=[],
                 this.errors=[]
         }).catch((errors) => {
                if (errors.response.status == 422) {
                    this.errors = errors.response.data.errors
                    toast.fire({
                     icon: 'error',title: 'error al registrar la Información'
                })
             }
         })
        }
         },
         habeasData(){
             toast.fire({
                    icon: 'info',
                    title:'Autorizo el tratamiento de mis datos de acuerdo con la finalidad establecida en la política de protección de datos personales'
             })
         },
          getCities(){
                const params = {
                    '$q':this.data.department,
                    '$select':'municipio'
                }
                 axios.get('https://www.datos.gov.co/resource/xdk5-pm3f.json?',{ params }).then((response) => {
            this.cities =response.data
             
         }).catch((errors) => {
               console.log(errors);
         })

          },
           getDepartments(){
               const params = {
                   '$select':'departamento',
                   '$group':'departamento'
                //    '$having':'COUNT(departamento)>2'
               }
         axios.get('https://www.datos.gov.co/resource/xdk5-pm3f.json?',{ params }).then((response) => {
            this.departments =response.data
         }).catch((errors) => {
             
         })
         }
        }
    }
</script>
