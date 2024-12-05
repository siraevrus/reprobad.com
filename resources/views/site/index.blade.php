@extends('site.layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <div class="sistema-repro-heading">
            <p class="sistema-repro-p"><strong>Система РЕПРО</strong> - это программа, созданная для нормализации дисбалансов в организме человека, основанная на индивидуальных потребностях пары. Комбинации нутрицевтических ингредиентов подобраны с участием врача-репродуктолога на основе 20-ти летнего опыта работы с парами, планирующими беременность. </p>
            <h1 class="sistema-repro-h1"><span class="sistema-repro-semibold">СИСТЕМА РЕПР</span><span class="o-span"><strong>О</strong></span> <span class="sistema-repro-h1-descriptor">подготовка пары к беременности</span></h1>
            <p class="sistema-repro-steps-p">4 важных шага</p>
        </div>
        <div class="_4-steps-wrap">
            <div class="step-item"><img src="images/1.svg" loading="lazy" alt="" class="step-item-number">
                <div class="step-item-content">
                    <h2 class="step-h">Психо-эмоциональное равновесие</h2>
                    <p class="step-description">Защита от стресса и нормализация сна</p>
                    <div class="step-products">
                        <a href="/product-protect#first" class="step-product-left w-inline-block">
                            <div class="sache-image-element"><img src="images/1-1_ReproRelaks_Giperkortizol_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/1-1_ReproRelaks_Giperkortizol_sashe_11-1_ReproRelaks_Giperkortizol_sashe.avif 500w, images/1-1_ReproRelaks_Giperkortizol_sashe_11-1_ReproRelaks_Giperkortizol_sashe.avif 800w, images/1-1_ReproRelaks_Giperkortizol_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="step-product-shadow"></div>
                        </a>
                        <a href="/product-protect#second" class="step-product-right w-inline-block">
                            <div class="sache-image-element"><img src="images/1-2_ReproRelaks_Gipokortizol_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/1-2_ReproRelaks_Gipokortizol_sashe_11-2_ReproRelaks_Gipokortizol_sashe.avif 500w, images/1-2_ReproRelaks_Gipokortizol_sashe_11-2_ReproRelaks_Gipokortizol_sashe.avif 800w, images/1-2_ReproRelaks_Gipokortizol_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="step-product-shadow gipokortizol"></div>
                        </a>
                    </div>
                    <a href="product-protect.html" class="step-button w-button">Подробнее —&gt;</a>
                </div>
                <div class="step-item-overlay"></div>
            </div>
            <div class="step-item _2"><img src="images/2.svg" loading="lazy" alt="" class="step-item-number">
                <div class="step-item-content">
                    <h2 class="step-h">Очищение <br>организма</h2>
                    <p class="step-description">Нормализация кишечной микрофлоры и поддержка печени</p>
                    <div class="step-products">
                        <a href="/product-detoxi#first" class="step-product-left w-inline-block">
                            <div class="sache-image-element"><img src="images/2-1_ReproDetoksi_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/2-1_ReproDetoksi_sashe_12-1_ReproDetoksi_sashe.avif 500w, images/2-1_ReproDetoksi_sashe_12-1_ReproDetoksi_sashe.avif 800w, images/2-1_ReproDetoksi_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="step-product-shadow detoxi"></div>
                        </a>
                        <a href="/product-detoxi#second" class="step-product-right w-inline-block">
                            <div class="sache-image-element"><img src="images/2-2_ReproBiom_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/2-2_ReproBiom_sashe_12-2_ReproBiom_sashe.avif 500w, images/2-2_ReproBiom_sashe_12-2_ReproBiom_sashe.avif 800w, images/2-2_ReproBiom_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="step-product-shadow biom"></div>
                        </a>
                    </div>
                    <a href="product-detoxi.html" class="step-button _2 w-button">Подробнее —&gt;</a>
                </div>
                <div class="step-item-overlay _2"></div>
            </div>
            <div class="step-item _3"><img src="images/3.svg" loading="lazy" alt="" class="step-item-number">
                <div class="step-item-content">
                    <h2 class="step-h">Общий метаболизм и углеводный обмен</h2>
                    <p class="step-description">Коррекция энергетического обмена и нормализация метаболизма</p>
                    <div class="step-products">
                        <a href="/product-energy#first" class="step-product-left w-inline-block">
                            <div class="sache-image-element"><img src="images/3-2_ReproMetabo_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/3-2_ReproMetabo_sashe_13-2_ReproMetabo_sashe.avif 500w, images/3-2_ReproMetabo_sashe_13-2_ReproMetabo_sashe.avif 800w, images/3-2_ReproMetabo_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="step-product-shadow metabo"></div>
                        </a>
                        <a href="/product-energy#second" class="step-product-right w-inline-block">
                            <div class="sache-image-element"><img src="images/3-1_ReproEnerdzhi_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/3-1_ReproEnerdzhi_sashe_13-1_ReproEnerdzhi_sashe.avif 500w, images/3-1_ReproEnerdzhi_sashe_13-1_ReproEnerdzhi_sashe.avif 800w, images/3-1_ReproEnerdzhi_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="step-product-shadow energy"></div>
                        </a>
                    </div>
                    <a href="product-energy.html" class="step-button _3 w-button">Подробнее —&gt;</a>
                </div>
                <div class="step-item-overlay _3"></div>
            </div>
            <div class="step-item _4"><img src="images/4.svg" loading="lazy" alt="" class="step-item-number">
                <div class="step-item-content">
                    <h2 class="step-h">Здоровая наследственность</h2>
                    <p class="step-description">Поддержка репродуктивного здоровья</p>
                    <div class="step-products">
                        <a href="/product-embrio#first" class="step-product-left repro-embrio w-inline-block">
                            <div class="sache-image-element"><img src="images/4-1_ReproEmbrio_sahe-1_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/4-1_ReproEmbrio_sahe-1_14-1_ReproEmbrio_sahe-1.avif 500w, images/4-1_ReproEmbrio_sahe-1_14-1_ReproEmbrio_sahe-1.avif 800w, images/4-1_ReproEmbrio_sahe-1_1.avif 866w" class="sache-image"></div>
                            <div class="step-product-shadow embrio"></div>
                        </a>
                        <a href="/product-embrio#second" class="step-product-right repro-genom w-inline-block">
                            <div class="bottle-image-element"><img sizes="(max-width: 479px) 34vw, (max-width: 767px) 35vw, 9vw" srcset="images/4-2_ReproGenom_banka_14-2_ReproGenom_banka.avif 500w, images/4-2_ReproGenom_banka_1.avif 1122w" alt="" loading="lazy" src="images/4-2_ReproGenom_banka_1.avif" class="bottle-image"></div>
                        </a>
                    </div>
                    <a href="product-embrio.html" class="step-button _4 w-button">Подробнее —&gt;</a>
                </div>
                <div class="step-item-overlay _4"></div>
            </div>
        </div>
    </div>
</section>
<section class="section home-buy-section">
    <div class="container home-buy-container">
        <a href="products.html" class="home-buy-button w-inline-block"></a>
    </div>
</section>
<section class="widgets-section">
    <div class="container widgets-container">
        <div class="widgets-column">
            <div class="map-widget">
                <h2 class="widget-h"><strong>Купить СИСТЕМУ РЕПРО</strong> <span class="inline-text-block">в ближайшей к вам аптеке</span></h2><img src="images/widget-map.webp" loading="lazy" sizes="(max-width: 767px) 100vw, 33vw" srcset="images/widget-map-p-500.webp 500w, images/widget-map.webp 680w" alt="" class="map-widget-image">
                <div class="map-widget-input-wrap"><input type="text" name="search" placeholder="Ваш адрес" autocomplete="off" class="input">
                    <a href="#" class="map-widget-button w-button"><span class="hide-on-mobile">Найти </span>—&gt;</a>
                </div>
            </div>
            <div class="shpargalka-widget">
                <h2 class="widget-h"><strong>Шпаргалка: каких врачей нужно пройти </strong>перед процедурой ЭКО</h2><img src="images/shpargalka.webp" loading="lazy" sizes="(max-width: 767px) 91vw, 49vw" srcset="images/shpargalka-p-500.webp 500w, images/shpargalka-p-800.webp 800w, images/shpargalka.webp 900w" alt="" class="shpargalka-image">
                <div class="shpargalka-docs">
                    <div class="shpargalka-doc"><strong class="shpargalka-doc-title">Терапевт</strong> анализы крови, ЭКГ</div>
                    <div class="shpargalka-doc"><strong class="shpargalka-doc-title">Эндокринолог </strong>анализ крови на гормоны и УЗИ щитовидной железы</div>
                    <div class="shpargalka-doc"><strong class="shpargalka-doc-title">Маммолог</strong> женщинам до 40 лет УЗИ молочных желез на 6-10 день цикла, после 40 маммография в 1 фазе цикла</div>
                </div>
                <div class="shpargalka-list">
                    <div class="shpargalka-list-item"><img src="images/man.svg" loading="lazy" alt="" class="shpargalka-list-icon">
                        <div><strong>Для мужа: </strong>консультация андролога является обязательной <br>при наличии мужского фактора бесплодия</div>
                    </div>
                    <div class="shpargalka-list-item"><img src="images/Plus-Circle.svg" loading="lazy" alt="" class="shpargalka-list-icon">
                        <div><strong>Консультации специалистов, </strong>которые могут быть рекомендованы: психолог, гематолог, генетик, онколог, иммунолог, кардиолог</div>
                    </div>
                </div>
                <div class="widget-footer">
                    <a href="article.html" class="button w-button">Подробнее —&gt;</a>
                </div>
            </div>
        </div>
        <div class="widgets-column _2">
            <div class="questions-widget">
                <h2 class="widget-h"><strong>15 вопросов репродуктологу </strong><span class="inline-text-block">на первом приёме </span></h2>
                <div class="questions-slider">
                    <div class="questions-slider-wrap">
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Есть ли возрастные ограничения для лечения бесплодия?</div>
                            <div class="questions-slide-text"> </div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Какие вспомогательные репродуктивные технологии (ВРТ) доступны на сегодняшний день?</div>
                            <div class="questions-slide-text"> </div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Какие показания и противопоказания есть к существующим методикам зачатия?</div>
                            <div class="questions-slide-text"> </div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Что лучше выбрать – внутриматочную инсеминацию (ВМИ) или экстракорпоральное оплодотворение (ЭКО)?</div>
                            <div class="questions-slide-text"> </div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Как подготовить организм к процедуре ЭКО?</div>
                            <div class="questions-slide-text"> </div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Какое питание рекомендовано при планировании беременности? </div>
                            <div class="questions-slide-text"></div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Какие витамины и минералы могут поддержать организм при подготовке к ЭКО?</div>
                            <div class="questions-slide-text"></div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Сколько времени от начала до конца занимает каждая процедура?</div>
                            <div class="questions-slide-text"></div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Какие анализы и обследования нужно пройти предварительно?</div>
                            <div class="questions-slide-text"></div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Лучше перенести один или несколько эмбрионов?</div>
                            <div class="questions-slide-text"></div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">От чего зависит успех протокола?</div>
                            <div class="questions-slide-text"></div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Сколько раз можно повторять процедуру ЭКО?<br></div>
                            <div class="questions-slide-text"></div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Какова стоимость лечения и финансовые риски?</div>
                            <div class="questions-slide-text"></div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Можно ли сделать процедуру ЭКО по ОМС?</div>
                            <div class="questions-slide-text"></div>
                        </div>
                        <div class="questions-slide"><img src="images/question-slide-icon.svg" loading="lazy" alt="" class="questions-slide-icon">
                            <div class="questions-slide-h">Какие побочные эффекты от лечения могут возникнуть?</div>
                            <div class="questions-slide-text"></div>
                        </div>
                    </div>
                </div>
                <div class="widget-footer">
                    <a href="#" class="prev-slider-button w-inline-block"><img src="images/l-arr.svg" loading="lazy" alt="" class="slider-arrow"></a>
                    <a href="article.html" class="button w-button">Узнать больше —&gt;</a>
                    <a href="#" class="next-slider-button w-inline-block"><img src="images/r-arr.svg" loading="lazy" alt="" class="slider-arrow"></a>
                </div>
            </div>
            <div class="top-5-widget">
                <div class="top-5-overlay"></div>
                <div class="top-5-overlay right"></div>
                <h2 class="widget-h"><span class="inline-text-block"><strong>Этапы подготовки к ЭКО</strong></span></h2>
                <div class="top-5-slider">
                    <div class="top-5-slider-wrap">
                        <div class="top-5-slide">
                            <div>Здоровый образ жизни</div>
                        </div>
                        <div class="top-5-slide">
                            <div>Снижение уровня стресса</div>
                        </div>
                        <div class="top-5-slide">
                            <div>Финансовое планирование</div>
                        </div>
                        <div class="top-5-slide">
                            <div>Консультации специалистов</div>
                        </div>
                    </div>
                    <div class="top-5-slider-pagination">
                        <div class="top-5-slider-dot active">1</div>
                        <div class="top-5-slider-dot">2</div>
                        <div class="top-5-slider-dot">3</div>
                        <div class="top-5-slider-dot">4</div>
                    </div>
                </div>
                <div class="widget-footer">
                    <a href="#" class="prev-slider-button w-inline-block"><img src="images/l-arr.svg" loading="lazy" alt="" class="slider-arrow"></a>
                    <a href="article.html" class="button w-button">Все способы —&gt;</a>
                    <a href="#" class="next-slider-button w-inline-block"><img src="images/r-arr.svg" loading="lazy" alt="" class="slider-arrow"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="footer-section">
    <div class="footer-container">
        <a href="index.html" aria-current="page" class="footer-logo-link w-inline-block w--current"><img src="images/logo-black.svg" loading="lazy" alt="РЕПРО АПОТЕКА • REPRO APOTHEKA" class="footer-logo"></a>
        <div class="footer-contacts">
            <div>
                <a href="tel:+74959567937" class="footer-phone">+7 495 956 79 37</a>
                <a href="mailto:info@reproapotheka.ru" class="footer-email">info@reproapotheka.ru</a>
            </div>
            <div class="social-icons">
                <a href="#" class="social-link w-inline-block">
                    <div class="social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M16,0 C24.8365333,0 32,7.16346667 32,16 C32,24.8365333 24.8365333,32 16,32 C7.16346667,32 0,24.8365333 0,16 C0,7.16346667 7.16346667,0 16,0 Z M17.3874716,11.1336625 L8,11.1336625 L8,22 L10.6670977,22 L10.6670977,18.4647589 L15.5822937,18.4647589 L17.9145854,22 L20.9011635,22 L18.3298027,18.4481815 C19.2778351,18.3046561 19.7034381,18.0081168 20.0546093,17.5191924 C20.4056724,17.0303334 20.5816907,16.2487305 20.5816907,15.205619 L20.5816907,14.3908285 C20.5816907,13.7721859 20.5175365,13.283316 20.4056724,12.908612 C20.2937,12.533919 20.1024275,12.2080094 19.8307729,11.9152655 C19.5437559,11.6381501 19.2241749,11.4429839 18.840548,11.3122296 C18.5118176,11.214373 18.1127443,11.1523653 17.6337017,11.1366459 L17.3874716,11.1336625 Z M16.9560265,13.5292178 C17.3233715,13.5292178 17.5787983,13.5945895 17.7069877,13.7087555 C17.835177,13.8229324 17.9145854,14.034676 17.9145854,14.3439973 L17.9145854,15.2563545 C17.9145854,15.5822642 17.835177,15.7940078 17.7069877,15.9081738 C17.597111,16.0060397 17.3937539,16.0558614 17.1065633,16.0680989 L16.9560265,16.0701634 L10.6670977,16.0701634 L10.6670977,13.5292178 L16.9560265,13.5292178 Z M22.9510686,7 C21.8193366,7 20.9020289,7.92512727 20.9020289,9.06631813 C20.9020289,10.2075199 21.8193366,11.1326374 22.9510686,11.1326374 C24.0826923,11.1326374 25,10.2075199 25,9.06631813 C25,7.92512727 24.0826923,7 22.9510686,7 Z" fill="currentColor"></path>
                        </svg></div>
                </a>
                <a href="https://t.me/reprobad" class="social-link w-inline-block">
                    <div class="social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg></div>
                </a>
            </div>
            <div class="footer-slogan"><strong>Мы стараемся для вас, чтобы вы старались для них!</strong></div>
        </div>
        <div class="footer-menu">
            <div class="footer-menu-column">
                <a href="about.html" class="footer-menu-link">О системе РЕПРО</a>
                <a href="products.html" class="footer-menu-link">Продукты</a>
                <a href="events.html" class="footer-menu-link">События</a>
                <a href="useful-tips.html" class="footer-menu-link">Полезные советы</a>
                <a href="articles.html" class="footer-menu-link">Статьи</a>
            </div>
            <div class="footer-menu-column">
                <a href="map.html" class="footer-menu-link">Где купить</a>
                <a href="company.html" class="footer-menu-link">О компании</a>
                <a href="company.html" class="footer-menu-link">Вопросы-ответы</a>
                <a href="contacts.html" class="footer-menu-link">Контакты</a>
            </div>
            <a href="privacy.html" target="_blank" class="footer-terms-link">Политика конфиденциальности в отношении персональных данных</a>
        </div>
        <div class="r-farm-footer">
            <a href="https://www.r-pharm.com/ru" target="_blank" class="r-farm-footer-link w-inline-block"><img src="images/RFarm-footer.png" loading="lazy" alt="Р-Фарм" class="r-farm-image"></a>
            <div>ООО «Р-Фарм Косметикс»<br>Адрес: 119421, г. Москва, Ленинский проспект, д.111, корп.1, этаж 5, ком.128.</div>
            <div>БАД. НЕ ЯВЛЯЕТСЯ ЛЕКАРСТВЕННЫМ СРЕДСТВОМ. ИМЕЮТСЯ ПРОТИВОПОКАЗАНИЯ. НЕОБХОДИМО ПРОКОНСУЛЬТИРОВАТЬСЯ СО СПЕЦИАЛИСТОМ.</div>
        </div>
    </div>
    <div class="bad-wrap">
        <div class="bad-container">
            <div class="bad-text"></div>
            <a href="#" class="bad-close w-inline-block"><img src="images/bad-close.svg" loading="lazy" alt="" class="bad-close-image"></a>
        </div>
    </div>
    <div class="cookies-banner">
        <div class="cookies-wrap">
            <div class="cookies">
                <div class="cookies-text">Этот веб-сайт использует файлы cookies, чтобы обеспечить удобную работу пользователей с ним и функциональные возможности сайта. Нажимая &quot;Я принимаю&quot; вы соглашаетесь с <a href="privacy.html" target="_blank" class="cookies-text-link">условиями использования файлов cookies</a>
                </div>
                <a href="#" class="accept-cookies w-button">Принимаю</a>
            </div>
        </div>
    </div>
</section>
<div class="products-popup">
    <div class="products-popup-head">
        <div class="product-popup-head-container">
            <a href="#" class="products-popup-close-button w-inline-block">
                <div>Закрыть</div><img src="images/wx.svg" loading="lazy" alt="" class="products-popup-close-cross">
            </a>
        </div>
    </div>
    <div class="products-popup-body">
        <div class="product-popup-container">
            <div class="products-grid">
                <div class="product-item">
                    <div class="product-item-content">
                        <div class="product-item-logo big"><img src="images/reprorelaxgiperkortizol.svg" loading="lazy" id="repro_2" alt="" class="repro-relax-giper-logo"></div>
                        <p class="product-item-text">Компоненты комплекса способствуют защите от стресса и нормализации сна</p>
                        <a href="/product-protect#first" class="product-item-link w-inline-block">
                            <div class="sache-image-element"><img src="images/1-1_ReproRelaks_Giperkortizol_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/1-1_ReproRelaks_Giperkortizol_sashe_11-1_ReproRelaks_Giperkortizol_sashe.avif 500w, images/1-1_ReproRelaks_Giperkortizol_sashe_11-1_ReproRelaks_Giperkortizol_sashe.avif 800w, images/1-1_ReproRelaks_Giperkortizol_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="product-item-image-shadow"></div>
                        </a>
                        <div class="product-item-button-wrap">
                            <a href="/product-protect#first" class="button w-button">Подробнее —&gt;</a>
                        </div>
                    </div>
                </div>
                <div class="product-item">
                    <div class="product-item-content">
                        <div class="product-item-logo big"><img src="images/gktz-logo.svg" loading="lazy" alt="" class="repro-relax-gipo-logo"></div>
                        <p class="product-item-text">Компоненты комплекса способствуют повышению устойчивости к стрессу</p>
                        <a href="/product-protect#second" class="product-item-link w-inline-block">
                            <div class="sache-image-element"><img src="images/1-2_ReproRelaks_Gipokortizol_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/1-2_ReproRelaks_Gipokortizol_sashe_11-2_ReproRelaks_Gipokortizol_sashe.avif 500w, images/1-2_ReproRelaks_Gipokortizol_sashe_11-2_ReproRelaks_Gipokortizol_sashe.avif 800w, images/1-2_ReproRelaks_Gipokortizol_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="product-item-image-shadow repro-relax-gipo"></div>
                        </a>
                        <div class="product-item-button-wrap">
                            <a href="/product-protect#second" class="button w-button">Подробнее —&gt;</a>
                        </div>
                    </div>
                </div>
                <div class="product-item">
                    <div class="product-item-content">
                        <div class="product-item-logo"><img src="images/repro-detoxi-logo.svg" loading="lazy" alt="РЕПРО ДЕТОКСИ" class="repro-detoxi-logo"></div>
                        <p class="product-item-text">Компоненты комплекса способствуют выведению токсинов и поддержке функции печени</p>
                        <a href="/product-detoxi#first" class="product-item-link w-inline-block">
                            <div class="sache-image-element"><img src="images/2-1_ReproDetoksi_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/2-1_ReproDetoksi_sashe_12-1_ReproDetoksi_sashe.avif 500w, images/2-1_ReproDetoksi_sashe_12-1_ReproDetoksi_sashe.avif 800w, images/2-1_ReproDetoksi_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="product-item-image-shadow repro-detoxi"></div>
                        </a>
                        <div class="product-item-button-wrap">
                            <a href="/product-detoxi#first" class="button w-button">Подробнее —&gt;</a>
                        </div>
                    </div>
                </div>
                <div class="product-item">
                    <div class="product-item-content">
                        <div class="product-item-logo"><img src="images/repro-biom-logo.svg" loading="lazy" alt="РЕПРО БИОМ" class="repro-biom-logo"></div>
                        <p class="product-item-text">Здоровый баланс кишечной микрофлоры</p>
                        <a href="/product-detoxi#second" class="product-item-link w-inline-block">
                            <div class="sache-image-element"><img src="images/2-2_ReproBiom_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/2-2_ReproBiom_sashe_12-2_ReproBiom_sashe.avif 500w, images/2-2_ReproBiom_sashe_12-2_ReproBiom_sashe.avif 800w, images/2-2_ReproBiom_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="product-item-image-shadow repro-biom"></div>
                        </a>
                        <div class="product-item-button-wrap">
                            <a href="/product-detoxi#second" class="button w-button">Подробнее —&gt;</a>
                        </div>
                    </div>
                </div>
                <div class="product-item">
                    <div class="product-item-content">
                        <div class="product-item-logo"><img src="images/repro-metabo-logo.svg" loading="lazy" alt="РЕПРО МЕТАБО" class="repro-metabo-logo"></div>
                        <p class="product-item-text">Компоненты комплекса способствуют нормализации углеводного обмена</p>
                        <a href="/product-energy#first" class="product-item-link w-inline-block">
                            <div class="sache-image-element"><img src="images/3-2_ReproMetabo_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/3-2_ReproMetabo_sashe_13-2_ReproMetabo_sashe.avif 500w, images/3-2_ReproMetabo_sashe_13-2_ReproMetabo_sashe.avif 800w, images/3-2_ReproMetabo_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="product-item-image-shadow repro-metabo"></div>
                        </a>
                        <div class="product-item-button-wrap">
                            <a href="/product-energy#first" class="button w-button">Подробнее —&gt;</a>
                        </div>
                    </div>
                </div>
                <div class="product-item">
                    <div class="product-item-content">
                        <div class="product-item-logo"><img src="images/repro-energy-logo.svg" loading="lazy" alt="РЕПРО ЭНЕРДЖИ" class="repro-energy-logo"></div>
                        <p class="product-item-text">Компоненты комплекса способствуют улучшению энергетического обмена</p>
                        <a href="/product-energy#second" class="product-item-link w-inline-block">
                            <div class="sache-image-element"><img src="images/3-1_ReproEnerdzhi_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/3-1_ReproEnerdzhi_sashe_13-1_ReproEnerdzhi_sashe.avif 500w, images/3-1_ReproEnerdzhi_sashe_13-1_ReproEnerdzhi_sashe.avif 800w, images/3-1_ReproEnerdzhi_sashe_1.avif 866w" class="sache-image"></div>
                            <div class="product-item-image-shadow repro-energy"></div>
                        </a>
                        <div class="product-item-button-wrap">
                            <a href="/product-energy#second" class="button w-button">Подробнее —&gt;</a>
                        </div>
                    </div>
                </div>
                <div class="product-item">
                    <div class="product-item-content">
                        <div class="product-item-logo"><img src="images/repro-embrio-logo.svg" loading="lazy" alt="РЕПРО ЭМБРИО" class="repro-embrio-logo"></div>
                        <p class="product-item-text">Компоненты комплекса принимают участие в регуляции репродуктивной функции</p>
                        <a href="/product-embrio#first" class="product-item-link w-inline-block">
                            <div class="sache-image-element"><img src="images/4-1_ReproEmbrio_sahe-1_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/4-1_ReproEmbrio_sahe-1_14-1_ReproEmbrio_sahe-1.avif 500w, images/4-1_ReproEmbrio_sahe-1_14-1_ReproEmbrio_sahe-1.avif 800w, images/4-1_ReproEmbrio_sahe-1_1.avif 866w" class="sache-image"></div>
                            <div class="product-item-image-shadow repro-embrio"></div>
                        </a>
                        <div class="product-item-button-wrap">
                            <a href="/product-embrio#first" class="button w-button">Подробнее —&gt;</a>
                        </div>
                    </div>
                </div>
                <div class="product-item">
                    <div class="product-item-content">
                        <div class="product-item-logo"><img src="images/repro-genom-logo.svg" loading="lazy" id="w-node-_1eb8d395-1f53-372e-23e1-58ca51ffe4ff-51ffe4ff" alt="" class="repro-genom-logo"></div>
                        <p class="product-item-text">Витамины группы B <br>для поддержания<br>репродуктивного здоровья</p>
                        <a href="/product-embrio#second" class="product-item-link bottle w-inline-block">
                            <div class="bottle-image-element"><img sizes="(max-width: 479px) 34vw, (max-width: 767px) 35vw, 9vw" srcset="images/4-2_ReproGenom_banka_14-2_ReproGenom_banka.avif 500w, images/4-2_ReproGenom_banka_1.avif 1122w" alt="" loading="lazy" src="images/4-2_ReproGenom_banka_1.avif" class="bottle-image"></div>
                        </a>
                        <div class="product-item-button-wrap">
                            <a href="/product-embrio#second" class="button w-button">Подробнее —&gt;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
