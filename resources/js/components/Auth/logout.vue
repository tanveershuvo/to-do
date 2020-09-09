<script>
export default {
    created(){
        //Event catch on Todolist Component
        EventBus.$emit('logout');
    }
}
</script>

