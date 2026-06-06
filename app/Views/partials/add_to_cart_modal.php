<div class="modal fade"
     id="cartModal<?= $product['id'] ?>"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <form method="post"
              action="<?= base_url('cart/add/' . $product['id']) ?>">

            <div class="modal-content border-0 shadow">

                <!-- HEADER -->
                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-cart-plus me-2"></i>
                        Add to Cart

                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <div class="row">

                        <!-- IMAGE -->
                        <div class="col-md-5 text-center">

                            <?php if(!empty($product['image'])): ?>

                                <img src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                     class="img-fluid rounded border p-2"
                                     style="max-height:250px; object-fit:contain;">

                            <?php else: ?>

                                <div class="d-flex align-items-center justify-content-center bg-light rounded border"
                                     style="height:250px;">

                                    <i class="bi bi-image text-secondary"
                                       style="font-size:5rem;"></i>

                                </div>

                            <?php endif; ?>

                        </div>

                        <!-- DETAILS -->
                        <div class="col-md-7">

                            <!-- CATEGORY -->
                            <span class="badge bg-secondary mb-2">
                                <?= esc($product['category_name'] ?? 'Uncategorized') ?>
                            </span>

                            <!-- PRODUCT NAME -->
                            <h4 class="fw-bold mb-1">
                                <?= esc($product['name']) ?>
                            </h4>

                            <!-- PRICE -->
                            <h5 class="text-primary fw-bold mb-3">
                                ₱<?= number_format($product['price'], 2) ?>
                            </h5>

                            <!-- DESCRIPTION -->
                            <p class="text-muted small">
                                <?= !empty($product['description'])
                                    ? nl2br(esc($product['description']))
                                    : 'No description available.' ?>
                            </p>

                            <!-- STOCK STATUS -->
                            <div class="mb-3">

                                <?php if($product['stock'] > 10): ?>
                                    <span class="badge bg-success">
                                        In Stock: <?= $product['stock'] ?>
                                    </span>

                                <?php elseif($product['stock'] > 0): ?>
                                    <span class="badge bg-warning text-dark">
                                        Low Stock: <?= $product['stock'] ?>
                                    </span>

                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        Out of Stock
                                    </span>
                                <?php endif; ?>

                            </div>

                            <!-- CART INFO -->
                            <?php $inCart = $cartMap[$product['id']] ?? 0; ?>

                            <?php if($inCart > 0): ?>
                                <div class="alert alert-info py-2">
                                    <i class="bi bi-cart-check me-1"></i>
                                    You already have <strong><?= $inCart ?></strong> in your cart
                                </div>
                            <?php endif; ?>

                            <!-- QUANTITY -->
                            <label class="form-label fw-semibold">
                                Quantity
                            </label>

                            <input type="number"
                                   name="quantity"
                                   min="1"
                                   max="<?= $product['stock'] ?>"
                                   value="1"
                                   class="form-control"
                                   <?= ($product['stock'] <= 0) ? 'disabled' : '' ?>>

                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <?php
                    $inCart = $cartMap[$product['id']] ?? 0;
                    $stock = $product['stock'];
                    $canAdd = $inCart < $stock;
                ?>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <?php if($stock <= 0): ?>

                        <button type="button"
                                class="btn btn-danger"
                                disabled>
                            Out of Stock
                        </button>

                    <?php elseif(!$canAdd): ?>

                        <button type="button"
                                class="btn btn-warning"
                                disabled>
                            Max Stock Reached (<?= $inCart ?>/<?= $stock ?>)
                        </button>

                    <?php else: ?>

                        <button type="submit"
                                class="btn btn-primary">
                            <i class="bi bi-cart-plus me-1"></i>
                            Add to Cart
                        </button>

                    <?php endif; ?>

                </div>

            </div>

        </form>

    </div>

</div>