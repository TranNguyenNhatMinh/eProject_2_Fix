<?php
$currentSite = 'boardwalk';
$currentPage = 'beach';
include __DIR__ . '/../includes/header.php';
?>
<main class="beach-page">
    <!-- Ảnh đầu trang — style giống card boardwalk -->
    <div class="beach-inner beach-top-image-wrap">
        <div class="beach-top-image">
            <img src="../img/boardwalk/beach.webp" alt="Jenkinson's Beach">
        </div>
    </div>

    <!-- Badges -->
    <section class="beach-section" id="badges">
        <div class="beach-inner">
            <h2 class="beach-section__title">Beach Badges</h2>
            <p class="beach-section__lead">Your badge supports maintenance, lifeguards, and facilities for a safe shoreline.</p>

            <div class="beach-where">
                <strong><i class="bi bi-geo-alt"></i> Where to buy</strong>
                <p>South Arcade or Pavilion Office · South Arcade: Daily 10 AM · Pavilion: M–F 9 AM–5 PM</p>
            </div>

            <div class="beach-cards">
                <a href="#pricing" class="beach-card">
                    <i class="bi bi-calendar3"></i>
                    <h3>Full season</h3>
                    <span class="beach-card__link">View pricing →</span>
                </a>
                <a href="#pricing" class="beach-card">
                    <i class="bi bi-calendar-week"></i>
                    <h3>Daily & weekly</h3>
                    <span class="beach-card__link">View pricing →</span>
                </a>
                <a href="#hours" class="beach-card">
                    <i class="bi bi-person-badge"></i>
                    <h3>Season holders</h3>
                    <span class="beach-card__link">Hours & info →</span>
                </a>
                <a href="#pricing" class="beach-card">
                    <i class="bi bi-star"></i>
                    <h3>Military</h3>
                    <span class="beach-card__link">Learn more →</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="beach-section beach-section--alt" id="pricing">
        <div class="beach-inner">
            <h2 class="beach-section__title">Pricing</h2>

            <div class="beach-pricing-grid">
                <div class="beach-pricing-card">
                    <h3>Full season</h3>
                    <ul>
                        <li><span>Adult</span><b>$110</b></li>
                        <li><span>Senior</span><b>$85</b></li>
                        <li><span>Child</span><b>$70</b></li>
                        <li><span>Infant (under 5)</span><b>Free</b></li>
                    </ul>
                    <p class="beach-pricing-note"><i class="bi bi-info-circle"></i> ID required for senior rate.</p>
                </div>
                <div class="beach-pricing-card">
                    <h3>Half season <small>Aug 1 – Sep 5</small></h3>
                    <ul>
                        <li><span>Adult</span><b>$70</b></li>
                        <li><span>Senior</span><b>$60</b></li>
                        <li><span>Child</span><b>$45</b></li>
                        <li><span>Infant (under 5)</span><b>Free</b></li>
                    </ul>
                </div>
            </div>

            <div class="beach-table-block">
                <h3>Daily & weekly</h3>
                <table class="beach-table">
                    <thead>
                        <tr><th>Type</th><th>Daily</th><th>Weekly</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Adult</td><td>$12</td><td>$65</td></tr>
                        <tr><td>Senior</td><td>$9</td><td>$45</td></tr>
                        <tr><td>Child (5–11)</td><td>$3</td><td>$15</td></tr>
                        <tr><td>Infant (under 5)</td><td>Free</td><td>Free</td></tr>
                        <tr><td>Military (active & retired)</td><td>Free</td><td>Free</td></tr>
                    </tbody>
                </table>
                <p class="beach-table-note"><i class="bi bi-exclamation-triangle"></i> Non-refundable, non-transferable.</p>
            </div>

            <p class="beach-tip">Daily & weekly badges at South Arcade or Pavilion Office during operating hours.</p>
        </div>
    </section>

    <!-- Hours & Info -->
    <section class="beach-section" id="hours">
        <div class="beach-inner">
            <h2 class="beach-section__title">Hours & info</h2>
            <div class="beach-two-col">
                <figure class="beach-figure">
                    <img src="../img/body2/b5.jpg" alt="Beach">
                </figure>
                <div class="beach-info">
                    <div class="beach-info__item">
                        <h3>Beach hours</h3>
                        <p>Lifeguarded during posted hours. Check signs for schedules.</p>
                        <div class="beach-alert">
                            <i class="bi bi-shield-exclamation"></i>
                            <p>Not responsible for injuries outside lifeguarded hours. Lifeguards typically Memorial Day – Labor Day.</p>
                        </div>
                    </div>
                    <div class="beach-info__item">
                        <h3>Bathhouses</h3>
                        <p>Near entrance: changing rooms, restrooms, showers. Badge may be required in peak season.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rules -->
    <section class="beach-section beach-section--alt">
        <div class="beach-inner">
            <h2 class="beach-section__title">Rules & tips</h2>

            <div class="beach-rules-box beach-rules-box--no">
                <h3><i class="bi bi-x-circle"></i> Not permitted</h3>
                <ul>
                    <li>Alcohol</li><li>Glass</li><li>Smoking / vaping</li><li>Tents</li><li>Pets</li>
                    <li>Loud music</li><li>Tables</li><li>Drones</li><li>Warming trays, pots, pans, BBQ</li>
                </ul>
            </div>

            <div class="beach-rules-box beach-rules-box--law">
                <i class="bi bi-file-earmark-text"></i>
                <div>
                    <p>Per Point Pleasant Beach ordinance</p>
                    <strong>Max cooler: 18" × 13.5" × 13.5"</strong>
                </div>
            </div>

            <div class="beach-rules-box">
                <h3><i class="bi bi-rulers"></i> Size limits</h3>
                <ul>
                    <li>Canopy over 10' × 10'</li>
                    <li>Canopy with side walls</li>
                    <li>Baby tents over 36" × 36" × 36"</li>
                    <li>Umbrellas over 8' diameter</li>
                </ul>
            </div>

            <div class="beach-rules-end">
                <p class="beach-rules-end__thanks">Thank you!</p>
                <p class="beach-rules-end__bye">Have a great day.</p>
            </div>
            <p class="beach-rules-footer">Follow lifeguard instructions and respect others. Enjoy a safe visit.</p>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
