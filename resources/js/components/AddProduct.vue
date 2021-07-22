<template>
    <div class = "container">
        <h4 class="text-center">Adicionar Produto</h4>


                <form @submit.prevent="addProduct">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" class="form-control" v-model="product.descricao">
                    </div>
                    <div class="form-group">
                        <label>Valor</label>
                        <input type="text" class="form-control" v-model="product.valor">
                    </div>
                    <div class="form-group">
                        <label>Quantidade</label>
                        <input type="text" class="form-control" v-model="product.quantidade">
                    </div>
                    <button type="submit" class="btn btn-primary confirm">Adicionar</button>
                </form>

    </div>

</template>

<script>
export default {
    data() {
        return {
            product: {}
        }
    },
    methods: {
        addProduct() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/products/add', this.product)
                    .then(response => {
                        this.$router.push({name: 'products'})
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
