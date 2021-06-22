<template>
    <div>
        <el-dialog  v-if="addUserDialogFormVisible"
            title="Add New User"
            :visible.sync="addUserDialogFormVisible"
             width="50%"
            @close="addUserDialogClose"
            >
            <ValidationObserver  v-slot="{ invalid }">
            <el-form ref="form" :model="form" label-width="130px">
                    
                    <el-form-item label="Name*">
                        <ValidationProvider name="name"  rules="required|alpha_spaces" v-slot="{ errors }">
                            <el-input v-model="form.name" placeholder="Enter your name"></el-input>
                            <span>{{ errors[0] }}</span>
                        </ValidationProvider>
                    </el-form-item>
    
                    <el-form-item label="Phone Number*">
                        <ValidationProvider name="phone"  rules="required|digits:10" v-slot="{ errors }">
                            <el-input v-model="form.phone" placeholder="Enter your phone number"></el-input>
                            <span>{{ errors[0] }}</span>
                        </ValidationProvider>
                    </el-form-item>
                      <el-form-item label="Email*">
                        <ValidationProvider name="email"  rules="required|email" v-slot="{ errors }">
                            <el-input v-model="form.email" placeholder="Enter your email"></el-input>
                            <span>{{ errors[0] }}</span>
                        </ValidationProvider>
                    </el-form-item>
                    <el-form-item label="Gender*">
                        <ValidationProvider name="gender"  rules="required" v-slot="{ errors }">
                            <el-radio-group v-model="form.gender">
                            <el-radio label="Female"></el-radio>
                            <el-radio label="Male"></el-radio>
                            </el-radio-group>
                            <span>{{ errors[0] }}</span>
                        </ValidationProvider>
                    </el-form-item>
                     <el-form-item label="Password*">
                        <ValidationProvider name="password"  rules="required" v-slot="{ errors }">
                            <el-input v-model="form.password" placeholder="Enter your Password"></el-input>
                            <span>{{ errors[0] }}</span>
                        </ValidationProvider>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="saveUser()" :disabled="invalid">Save</el-button>
                        <el-button @click="addUserDialogFormVisible=false">Cancel</el-button>
                    </el-form-item>
                </el-form>
            </ValidationObserver>
        </el-dialog>
    </div>
</template>
<script>
export default {
    props: {
        addUserDialogFormVisible:{
            required:true
        }
    },
    data(){
        return{
            form:{
                name:'',
                phone:'',
                email:'',
                gender:'',
                password:''
            }
        }
    },
    methods:{
        addUserDialogClose()
        {
            this.$emit('update:addUserDialogFormVisible',false)
        },
        saveUser(){
            var app=this
            app.$axios.post('http://localhost/onlineshopping/public/login/saveUser',app.form)
                .then(function (response) {
                console.log(response)
                if(response.data.trim()=="success")
              {
                app.$message({
                  message: 'successfully registerd and wait for the mail',
                  type: 'success'
                });
                  app.$refs['form'].resetFields();
                  app.getUser();
              }
                })
        }
    }
}
</script>

