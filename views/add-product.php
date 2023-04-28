<div class="container">
    <!-- Navbar Part  -->
    <section id="sec-1">
        <div class="container">
            <article>
                <h1>{{title}}</h1>
                <div class="buttons">
                    <button id="save-btn">Save</button>
                    <Button  id="cancel-btn" onclick="window.location.replace('/')">Cancel</Button>

                </div>
            </article>
        </div>
    </section>
    <!-- Navbar Part  -->


    <!-- Products List Part -->
    <section id="sec2-addProduct">
        <div class="alert alert-danger d-none" role="alert">
            
        </div>
        
        <div class="container">

            <!-- Item Part -->
            <form id="product_form" method="POST" action="">
                <div class="my-2">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" name="sku" id="sku" value="" class="form-control">
                    <div class="invalid-feedback sku_error">
                    </div>
                </div>

                <div class="my-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="" class="form-control">
                    <div class="invalid-feedback name_error">
                    </div>
                </div>
                <div class="my-2">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" name="price" id="price" value="" class="form-control">
                    <div class="invalid-feedback price_error">
                    </div>
                </div>
                <div class="my-3">
                    <label for="productType" class="form-label">Type Switcher</label>
                    <select name="productType" id="productType" class="form-select">
                        <option value="">Select Type</option>
                        <option value="dvd">DVD</option>
                        <option value="furniture">Furniture</option>
                        <option value="book">Book</option>
                    </select>
                    <div class="invalid-feedback productType_error">
                    </div>
                </div>

                <!-- DVD Form -->
                <div class="DVD-form my-3 d-none" id="dvd-inputs">
                    <div>
                        <label for="size" class="form-label">Size (MB)</label>
                        <input type="number" name="size" id="size"  class="form-control">
                        <div class="invalid-feedback size_error">
                        </div>
                    </div>

                    <p class="mt-2">please enter DVD's size with MB.</p>
                </div>
                <!-- End OF DVD Form -->

                <!-- Furniture Form -->
                <div class="furniture-form my-3 d-none" id="furniture-inputs">
                    <div class="row">
                        <div class="col-4">
                            <label for="height" class="form-label">Height (CM)</label>
                            <input type="number" name="height" id="height" class="form-control">
                            <div class="invalid-feedback height_error">
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="width" class="form-label">Width (CM)</label>
                            <input type="number" name="width" id="width" class="form-control ">
                            <div class="invalid-feedback width_error">
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="length" class="form-label">Length (CM)</label>
                            <input type="number" name="length" id="length" class="form-control ">
                            <div class="invalid-feedback length_error">
                            </div>
                        </div>
                        <p class="mt-2">please enter furniture's Dimensions with CM.</p>
                    </div>
                </div>
                <!-- End of Furniture Form -->

                <!-- Book Form -->
                <div class="book-form my-3 d-none" id="book-inputs">
                    <div>
                        <label for="weight" class="form-label">Weight (KG)</label>
                        <input type="number" name="weight" id="weight" class="form-control">
                        <div class="invalid-feedback weight_error">
                        </div>
                    </div>
                    <p class="mt-2">please enter book's weight with KG</p>
                </div>
                <!-- End of Book Form -->
            </form>
            <!-- End OF Item Part -->

        </div>



</div>
</section>

</div>
<footer>
    {{footer}}
</footer>