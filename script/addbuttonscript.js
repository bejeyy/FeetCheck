document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function () {

        document.getElementById('modalProductName').textContent = this.dataset.name;
        document.getElementById('modalProductPrice').textContent = this.dataset.price;
        document.getElementById('modalProductImage').src = this.dataset.image;

        document.getElementById('modalProductId').value = this.dataset.id;
        document.getElementById('modalProductNameInput').value = this.dataset.name;
        document.getElementById('modalProductPriceInput').value = this.dataset.price;
        document.getElementById('modalProductImageInput').value = this.dataset.image;

        document.getElementById('quantity').value = 1;
    });
});
