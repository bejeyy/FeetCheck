document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function () {
        document.getElementById('modalProductName').textContent = this.dataset.name;
        document.getElementById('modalProductPrice').textContent = this.dataset.price;
        document.getElementById('modalProductImage').src = this.dataset.image;
        document.getElementById('quantity').value = 1;
    });
});
