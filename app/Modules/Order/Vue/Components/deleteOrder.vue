<template>
  <div>
    <el-dialog
      title="Delete Order"
      :visible.sync="deleteFormVisible"
      width="40%"
      @close="deleteHandleClose()"
    >
      <span>Are you sure want to delete this order ?</span>
      <span slot="footer" class="dialog-footer">
        <el-button @click="deleteHandleClose()">Cancel</el-button>
        <el-button type="primary" @click="deleteOrder()" :disabled="isDelete=false"
          >Confirm</el-button
        >
      </span>
    </el-dialog>
  </div>
</template>


<script>
export default {
    props:{
        deleteFormVisible:{
            required:true
        },
        getOrders:{
            required:true
        },
        delete_id:{
            required:true
        }

    },
  data() {
    return {
      deleteFormVisible: false,
      isDelete:false
    };
  },
  watch:{
      deleteFormVisible:function(){
          var app=this
          if(!(app.delete_id))
          {
              app.isDelete=true
          }
      }
  },
  methods: {
    deleteHandleClose() {
      this.$emit('update:deleteFormVisible',false)
      this.$emit('delete_id','')
    },
    deleteOrder(){
        var app=this
          app.$axios
        .get("http://localhost/beta-fact/public/order/delete_Order/"+ app.delete_id)
        .then(function (response) {
          console.log(response);
          if(response.data.trim()=="success")
          {
              app.$message({
              message: "successfully deleted",
              type: "success",
            });
            app.getOrders();
          }
        }
        )
    }
  },

};
</script>