<?php
// includes/footer.php
?>
    <!-- Footer - content per page (Aquarium / Boardwalk / Sweet Shop) -->
    <footer class="boardwalk-footer text-white pt-5 pb-4">
        <div class="container">
            <div class="row footer-row align-items-start">
                <!-- Column 1: Logo per page -->
                <div class="col-md-3 col-sm-6">
                    <div class="boardwalk-logo mb-3 text-center text-md-start">
                        <div class="boardwalk-logo-text mb-2">
                            <?php
                            $imgPath = (isset($currentSite) && ($currentSite === 'boardwalk' || $currentSite === 'sweet-shop')) ? '../' : '';
                            if (isset($currentSite) && $currentSite === 'sweet-shop'):
                            ?>
                                <img src="<?= $imgPath ?>img/sweetshop.png" alt="Jenkinson's Sweet Shop" class="footer-logo-img">
                            <?php else: ?>
                                <img src="<?= $imgPath ?>img/imgfooter.ong.png" alt="Jenkinson's Boardwalk Logo" class="footer-logo-img">
                            <?php endif; ?>
                        </div>
                        <?php if (!isset($currentSite) || $currentSite !== 'sweet-shop'): ?>
                        <div class="footer-badge mb-1">15 YEARS</div>
                        <div class="footer-badge">BEST VALUE</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Column 2: Visit - content per page -->
                <div class="col-md-3 col-sm-6">
                    <?php if (isset($currentSite) && $currentSite === 'sweet-shop'): ?>
                        <h6 class="mb-3 fw-bold hover-link">Visit the Sweet Shop</h6>
                        <p class="small mb-1 hover-link">300 Ocean Avenue</p>
                        <p class="small mb-1 hover-link">Point Pleasant Beach, NJ 08742</p>
                        <p class="small mb-0 hover-link">732-892-0600</p>
                    <?php elseif (isset($currentSite) && $currentSite === 'boardwalk'): ?>
                        <h6 class="mb-3 fw-bold hover-link">Visit the Boardwalk</h6>
                        <p class="small mb-1 hover-link">300 Ocean Avenue</p>
                        <p class="small mb-1 hover-link">Point Pleasant Beach, NJ 08742</p>
                        <p class="small mb-2 hover-link">732-892-0600</p>
                        <h6 class="mb-2 mt-3 fw-bold hover-link">Jenkinson's South</h6>
                        <p class="small mb-1 hover-link">500 Boardwalk</p>
                        <p class="small mb-1 hover-link">Point Pleasant Beach, NJ 08742</p>
                        <p class="small mb-0 hover-link">732-295-4334</p>
                    <?php else: ?>
                        <h6 class="mb-3 fw-bold hover-link">Visit the Boardwalk</h6>
                        <p class="small mb-1 hover-link">300 Ocean Avenue</p>
                        <p class="small mb-1 hover-link">Point Pleasant Beach, NJ 08742</p>
                        <p class="small mb-0 hover-link">732-892-0600</p>
                    <?php endif; ?>
                </div>

                <!-- Column 3: Plan Your Visit - links per page -->
                <div class="col-md-3 col-sm-6">
                    <h6 class="mb-3 fw-bold plan-visit-heading">Plan Your Visit</h6>
                    <ul class="list-unstyled small mb-0">
                        <?php if (isset($currentSite) && $currentSite === 'sweet-shop'): ?>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Sweet Shop</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Weddings &amp; Custom Favors</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Seasonal Sweets &amp; Treats</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Online Store</a></li>
                            <li class="mb-0"><a href="#" class="text-white text-decoration-none hover-link">Join Our Team</a></li>
                        <?php elseif (isset($currentSite) && $currentSite === 'boardwalk'): ?>
                            <?php $bp = (isset($basePath) ? $basePath : ''); ?>
                            <li class="mb-2"><a href="<?= $bp ?>index.php" class="text-white text-decoration-none hover-link">Aquarium</a></li>
                            <li class="mb-2"><a href="<?= $bp ?>componets/sweet-shop.php" class="text-white text-decoration-none hover-link">Sweet Shop</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Beach Cam</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Boardwalk Map</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Contact Us</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Join Our Team</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Boardwalk Bounce – Check Balance</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Privacy Policy</a></li>
                            <li class="mb-0"><a href="#" class="text-white text-decoration-none hover-link">Summer 2025 Events Brochure Request</a></li>
                        <?php else: ?>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-link">Join Our Team</a></li>
                            <li class="mb-0"><a href="#" class="text-white text-decoration-none hover-link">Adopt-An-Animal</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Column 4: Stay Connected -->
                <div class="col-md-3 col-sm-6">
                    <h6 class="mb-3 fw-bold">Stay Connected with Us for more!</h6>
                    <form class="newsletter-form d-flex flex-column gap-2" method="post" action="<?= (isset($currentSite) && ($currentSite === 'boardwalk' || $currentSite === 'sweet-shop')) ? '../' : '' ?>subscribe.php">
                        <input type="email" name="email" class="form-control" placeholder="E-Mail" required>
                        <button type="submit" class="btn btn-subscribe fw-semibold">SUBSCRIBE</button>
                    </form>
                </div>
            </div>
            <hr class="footer-divider my-4">
            <div class="footer-bottom text-center">
                <div class="mb-2">
                    <span class="small copyright-text">&copy; <?= date('Y') ?> Jenkinson's Boardwalk. All rights reserved.</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= (isset($currentSite) && ($currentSite === 'boardwalk' || $currentSite === 'sweet-shop')) ? '../' : '' ?>js/script.js?v=<?= time() ?>"></script>
</body>
</html>