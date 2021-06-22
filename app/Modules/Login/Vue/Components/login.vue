<template>
    <div>
        <el-dialog
        title="Tips"

        :visible.sync="logindialog"
        width="30%"
        @close="handleClose">
        <span>
            <ValidationObserver  v-slot="{ invalid }">
            <el-form ref="form" :model="form" label-width="130px">
                    <el-form-item label="User Name*">
                        <ValidationProvider name="username"  rules="required|email" v-slot="{ errors }">
                            <el-input placeholder="Please input" v-model="form.email"></el-input>
                            <span>{{ errors[0] }}</span>
                        </ValidationProvider>
                    </el-form-item>
                    <el-form-item label="Password*">
                        <ValidationProvider name="password"  rules="required" v-slot="{ errors }">
                            <el-input type="password" placeholder="Please password" v-model="form.password"></el-input>
                            <span>{{ errors[0] }}</span>
                        </ValidationProvider>
                    </el-form-item>
                    <el-form-item >
                        <span >
                            <el-button @click="logindialog = false">Cancel</el-button>
                            <el-button type="primary" @click="login()" :disabled="invalid">Login</el-button>
                        </span>
                    </el-form-item>
                </el-form>
            </ValidationObserver>
           
        </span>
        
        </el-dialog>
    </div>
</template>
<script>
export default {
    props:{
        logindialog:{
            required:true
        }
    },
    data() {
       return{
           form:{
               email:'',
               password:''
           }
           
       } 
    },
    methods:{
        handleClose()
        {
            this.$emit('update:logindialog',false)
        },
        login()
        {
            var app=this
            app.$axios.post('http://localhost/onlineshopping/public/login/loginValidation',app.form)
                .then(function (response) {
                console.log(response)
                if(response.data.trim()=="admin")
              {
                app.$message({
                  message: 'successfully Login',
                  type: 'success'
                });
               app.$router.push({name:'admin'})
                  
              }
                })

        }
    }
}
</script>