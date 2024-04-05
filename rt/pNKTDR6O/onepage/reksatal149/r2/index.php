<?php require('onepage.php') ?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <link rel="shortcut icon" href="star.ico" type="">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/main.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
  <title>Рексатал</title>
</head>

<body>
    <section class="nav">
        <div class="nav__wrap">
            <ul class="nav__list">
                <li class="nav__item"><a class="nav__link" href="#why">Почему Рексатал</a></li>
                <li class="nav__item"><a class="nav__link" href="#cons">Состав</a></li>
                <li class="nav__item"><a class="nav__link" href="#review">Отзывы</a></li>
                <a class="nav__btn" href="#bottom">Заказать<br> бесплатную консультацию</a>
            </ul>
        </div>
    </section>
    
  <header class="header">
    <div class="header__wrap">
      <div class="header__title">
        <span class="header__title--big">Рексатал</span>
        <span class="header__title--small">Активируйте <span class="header__title--accent">мощную потенцию<br></span> в любом возрасте!</span>
      </div>
      <div class="header__block">
        <div class="header__descr">Первый природный <span class="header__descr--accent">активатор естественной потенции</span> без вреда для здоровья и побочных эффектов!</div>
        <div class="header__list">
          <div class="header__item">Твердая и устойчивая <span class="header__item--accent">эрекция</span></div>
          <div class="header__item">Сильное сексуальное <span class="header__item--accent">желание</span></div>
          <div class="header__item"><span class="header__item--accent">Выносливость и контроль</span> эякуляции</div>
        </div>
        <div class="header__pic">
          <img src="product.png" style='max-width:290px' alt="" class="header__img">
          <div class="header__action">Упаковок по акции осталось: <span class="header__action--accent"><span class="pack_count"></span> шт</span></div>
          <div class="stamps header__stamps">
            <div class="stamps__item">
              <div class="stamps__text">Повышает <b>качество сексуальной
жизни</b> миллионов мужчин!
              </div>
            </div>
          </div>
        </div>
      </div>

      <form action="" method="POST" class="form header__form order_form">
        <div class="form__title">Оформите заказ<br> пока <span class="form__title--accent">действует акция!*</span></div>
        <div class="price">
         <span class="price__text" style="font-size: 19px;">Старая цена</span> <span class="price_main"><del><?= $oldPriceHtml ?>  <?= $currencyDisplayHtml ?></del> </span><br>
		  <span class="price__text" style="font-size: 30px;">Цена по акции:</span> <span class="price_main"><?= $newPriceHtml ?> <?= $currencyDisplayHtml ?> </span>
        </div>
        <label class="form__label">Выберите страну</label>
        <?= countrySelect() ?>
        <label class="form__label">Введите Ф.И.О.</label>
        <input class="form__input" type="text" name="name">
        <label class="form__label">Введите номер телефона</label>
        <input class="form__input" type="tel" name="phone">
        <button class="btn form__btn">Заказать</button>
          <div class="form__action">*при заказе комплексной программы</div>
      </form>

    </div>
  </header>

  <section class="easy">
    <div class="easy__wrap">
      <img src="img/easy__logo.png" alt="" class="easy__logo">
      <h3 class="easy__title">78% мужчин хотели бы улучшить качество
своей сексуальной жизни</h3>
      <div class="easy__block">
        <div class="easy__text">Мужчины попробовавшие <span class="easy__text--accent">Рексатал</span><br> в восторге от его действия.<br>
          <span class="easy__text--accent">Рексатал</span> дает мужскому организму все необходимые элементы для превосходной сексуальной активности в любом возрасте.</div>
        <div class="easy__descr">При курсовом приеме положительный результат не ограничен во времени!</div>
      </div>

      <div class="easy__pic">
        <img class="easy__img" src="product.png" style='max-width:290px' alt="">
      </div>
    </div>
  </section>

  <section class="reasons" id="why">
    <div class="reasons__wrap">
      <h3 class="reasons__title">Почему стоит <span class="reasons__title--accent">использовать Рексатал?</span></h3>
      <div class="reasons__list">
        <div class="reasons__item">
          <img src="img/reasons__pic1.png" alt="" class="reasons__pic">
          <div class="reasons__text">Уверенность в своих силах — <span class="reasons__text--accent">вы готовы
в любой момент!</span></div>
        </div>
        <div class="reasons__item">
          <img src="img/reasons__pic2.png" alt="" class="reasons__pic">
          <div class="reasons__text">Чтобы быть в постели как <span class="reasons__text--accent">настоящий жеребец</span></div>
        </div>
        <div class="reasons__item">
          <img src="img/reasons__pic3.png" alt="" class="reasons__pic">
          <div class="reasons__text">Чтобы <span class="reasons__text--accent">добавить много
качественного секса</span> в ваши отношения</div>
        </div>
        <div class="reasons__item">
          <img src="img/reasons__pic4.png" alt="" class="reasons__pic">
          <div class="reasons__text">Чтобы секс всегда был долгим, <span class="reasons__text--accent">Вы — альфа самец</span></div>
        </div>
      </div>
    </div>
  </section>

  <section class="blue">
    <div class="blue__wrap">
      <div class="blue__img">
        <img src="product.png" style='max-width:290px' alt="" class="blue__pack">
      </div>
      <div class="blue__block">
        <div class="blue__descr">Энергия, потенция, контроль семяизвержения, либидо и даже здоровая агрессивность — </div>
        <div class="blue__descr--accent">все что нужно современному мужчине в одной капсуле и без побочных эффектов!</div>
      </div>
      <a href="#bottom" class="btn blue__btn">Заказать</a>
    </div>
  </section>

  <section class="course">
    <div class="course__wrap">
      <div class="course__title">Рексатал заслужил <span class="course__title--accent">доверие!</span></div>
      <div class="course__descr">Три государственные награды, 95,5% положительных отзывов</div>
      <div class="course__block">
        <div class="course__item">
          <img src="img/icon1.png" alt="" class="course__icon">
          <div class="course__text"><span class="course__text--accent">Не имеет</span> противопоказаний и побочных эффектов</div>
        </div>
        <div class="course__item">
          <img src="img/icon2.png" alt="" class="course__icon">
          <div class="course__text">Высокая эффективность доказана <span class="course__text--accent">клиническими испытаниями</span></div>
        </div>
        <div class="course__item">
          <img src="img/icon3.png" alt="" class="course__icon">
          <div class="course__text">Можно использовать <span class="course__text--accent">с алкоголем и лекарственными средствами</span></div>
        </div>
        <div class="course__item">
          <img src="img/icon4.png" alt="" class="course__icon">
          <div class="course__text">Можно применять <span class="course__text--accent">в любом возрасте</span></div>
        </div>
        <div class="course__item">
          <img src="img/icon5.png" alt="" class="course__icon">
          <div class="course__text">Удерживает <span class="course__text--accent">безопасный уровень</span> артериального давления</div>
        </div>
      </div>
    </div>
  </section>


  <section class="about">
    <div class="about__wrap">
      <div class="about__block">
        <div class="about__title">Рексатал</div>
        <div class="about__descr">
          Повышает качество сексуальной жизни <span class="about__descr--accent">миллионов мужчин!</span>
        </div>
        <img src="product.png" style='max-width:290px' alt="" class="about__pic">
      </div>
      <div class="about__form">
        <form action="" method="POST" class="form order_form">
          <div class="form__title">Оформите заказ<br> пока <span class="form__title--accent">действует акция!*</span></div>
          <div class="price">
        <span class="price__text" style="font-size: 19px;">Старая цена</span> <span class="price_main"><del><?= $oldPriceHtml ?>  <?= $currencyDisplayHtml ?></del> </span><br>
		  <span class="price__text" style="font-size: 30px;">Цена по акции:</span> <span class="price_main"><?= $newPriceHtml ?> <?= $currencyDisplayHtml ?> </span>
          </div>
          <label class="form__label">Выберите страну</label>
          <?= countrySelect() ?>
          <label class="form__label">Введите Ф.И.О.</label>
          <input class="form__input" type="text" name="name">
          <label class="form__label">Введите номер телефона</label>
          <input class="form__input" type="tel" name="phone">
          <button class="btn form__btn">Заказать</button>
            <div class="form__action">*при заказе комплексной программы</div>
        </form>
      </div>
    </div>
  </section>


  <section class="trust">
    <div class="trust__wrap">
      <div class="trust__block">
        <div class="trust__title">Что говорят о Рексатал эксперты?</div>
        <div class="trust__text">
            Рексатал – <span class="trust__text--accent">это фармацевтический прорыв и абсолютная инновация.</span> Его основным действующим компонентом является алотрифалин. Теперь к средствам для улучшения потенции у государства и потребителей нет никаких претензий.
        </div>
        <div class="trust__text">
         Я поясню. Алотрифалин был создан взамен тадалфилу. Последний был разработан для лечения эректильной дисфункции и успешно использовался во многих препаратах для улучшения потенции. Эффективность этого ингибитора была феноменальная, пациенты отмечали усиление либидо уже в первые дни приема. Если не считать одно но –  <span class="trust__text--accent">снижение действия таблеток на основе тадалфила в долгосрочной перспективе, а также масса побочных действий со стороны сердечно-сосудистой системы вплоть до летального исхода.</span> Роспотребнадзор даже начал изымать из оборота таблетки, которые имели в составе тадалафил.
        </div>        
          <div class="trust__text">
              Алотрифалин пришел на смену тадалафилу как более безопасный и эффективный аналог. Именно с этим связана популярность Рексатала. Пропив курс, пациенты полностью решают свои проблемы с сексом, полностью восстанавливаются и отлично себя чувствуют. Все потому, что  <span class="trust__text--accent">Рексатал действует на физиологическую причину эректильной дисфункции, не имеет побочных действий и показывает эффективность даже у пожилых пациентов.</span> Ни одного негативного отзыва со стороны моих пациентов, все возвращаются с благодарностями.
        </div>
        <div class="trust__name">Подгорный Михаил Валерьевич<br> Сексопатолог, профессор, доктор медицинских наук.
          <img src="img/sign.png" alt="" class="trust__sign"></div>
      </div>
    </div>
  </section>

  <section class="choice">
    <div class="choice__wrap">
      <div class="choice__title">Распространенные интимные ситуации,<br>
в которых <span class="choice__title--accent">гарантированно поддержит РЕКСАТАЛ</span></div>
      <div class="choice__list">
        <div class="choice__item">
          <img src="img/choice__pic1.png" alt="" class="choice__pic">
          <div class="choice__text">Проблемы с достижением эрекции</div>
        </div>
        <div class="choice__item">
          <img src="img/choice__pic2.png" alt="" class="choice__pic">
          <div class="choice__text">Неустойчивая эрекция</div>
        </div>
        <div class="choice__item">
          <img src="img/choice__pic3.png" alt="" class="choice__pic">
          <div class="choice__text">Сложности с эрекцией после приема алкоголя</div>
        </div>
        <div class="choice__item">
          <img src="img/choice__pic4.png" alt="" class="choice__pic">
          <div class="choice__text">Боязнь интимной близости</div>
        </div>
        <div class="choice__item">
          <img src="img/choice__pic5.png" alt="" class="choice__pic">
          <div class="choice__text">Преждевременное семяизвержение</div>
        </div>
      </div>
    </div>
  </section>

 <section class="consist" id="cons">
    <div class="consist__wrap">
      <div class="consist__title">Проверенная формула:<br> 6 мощных <span class="consist__title--accent">натуральных компонентов</span></div>
        <img class="consist__pack" src="product.png" style='max-width:290px'>
      <div class="consist__list">
        <div class="consist__item">
          <img src="img/consist__pic1.png" alt="" class="consist__pic" width="150">
            <div class="consist__name">Сарсапарель</div>
          <div class="consist__text">снижает депрессию, <span class="consist__text--accent">утомляемость и усталость, регулирует сексуальную деятельность,</span> оказывает восстанавливающее действие</div>
        </div>        
          <div class="consist__item">

          <img src="img/consist__pic2.png" alt="" class="consist__pic" width="150">
              <div class="consist__name">Алотрифалин</div>
          <div class="consist__text">новый сверхуникальный <span class="consist__text--accent">НЕСИНТЕТИЧЕСКИЙ</span> компонент, разработанный как полная противоположность известного всем "Тадалафила". Соединил в себе все плюсы "Тадалафила" и при этом не имеет побочных действий</div>
        </div>  
          
          <div class="consist__item">   
          <img src="img/consist__pic3.png" alt="" class="consist__pic" width="150">
              <div class="consist__name">Фитостерины</div>
          <div class="consist__text">зародышей пшеницы - вещества, <span class="consist__text--accent">которые служат предшественниками стероидных гормонов.</span> Фитостерины разрывают связи тестостерона с белками, тем самым поднимая уровень активного тестостерона до естественной нормы</div>
        </div>        
          <div class="consist__item">
          <img src="img/consist__pic4.png" alt="" class="consist__pic" width="150">
              <div class="consist__name">Хамелириум</div>
          <div class="consist__text">используется для восстановления <span class="consist__text--accent">мужской половой функции при импотенции.</span> Так же обладает мочегонными, противовоспалительными свойствами</div>
        </div>       
          <div class="consist__item">

          <img src="img/consist__pic5.png" alt="" class="consist__pic" width="150">
              <div class="consist__name">Пория кокосовидная</div>
          <div class="consist__text">предотвращает разрушение красных кровяных клеток, защищая <span class="consist__text--accent">мочевыделительную систему от опухолевых процессов</span> при этом увеличивает либидо</div>
        </div>        
          <div class="consist__item">
  
          <img src="img/consist__pic6.png" alt="" class="consist__pic" width="150">
              <div class="consist__name">Перуанская мака</div>
          <div class="consist__text">натуральный афродизиак, <span class="consist__text--accent">повышающий потенцию и либидо.</span> Усиливает эрекцию, устраняет сексуальные расстройства</div>
        </div>

      </div>
    </div>
  </section>

  <section class="slider" id="review">
    <div class="slider__wrap">
      <div class="slider__title">Реальные люди - <br><span class="slider__title--accent">реальные результаты!</span></div>
      <div class="slider__block">
          <div class="slider__item">
            <img src="img/slider__pic1.png" alt="" class="slider__pic">
            <div class="slider__text">"РЕКСАТАЛ" вернул мне уверенность в себе!</div>
            <div class="slider__descr">"Возраст сказывается. Диагноз многим мужикам знакомый - простатит. С женой секса не было более полугода, а лечение не давало никаких результатов. Сменил врача, он мне и посоветовал РЕКСАТАЛ. Спустя две недели приема не мог поверить - ко мне ПОЛНОСТЬЮ вернулась мужская сила. Впервые за долгое время обрел уверенность. Сейчас жену удовлетворяю лучше, чем в молодости!"</div>
            <div class="slider__name">Александр, 58 лет</div>
          </div>
          <div class="slider__item">
            <img src="img/slider__pic2.png" alt="" class="slider__pic">
            <div class="slider__text">Теперь я готов к сексу в любой ситуации!</div>
            <div class="slider__descr">“Думаю многие мужики знают такое, когда после алкоголя стояк так себе, совсем вялый. Меня это сильно беспокоило - раз за разом мой секс с девушками в разгар веселья обламывался! 
Пропил курс РЕКСАТАЛ, теперь в любой момент стоит как каменный! Даже забыл, что когда-то были проблемы".</div>
            <div class="slider__name">Егор, 27 лет</div>
          </div>
          <div class="slider__item">
            <img src="img/slider__pic3.png" alt="" class="slider__pic">
            <div class="slider__text">"РЕКСАТАЛ" не оставит без секса даже в тяжелых ситуациях!</div>
            <div class="slider__descr">“Я в постоянном стрессе из-за работы, и раньше это сказывалось на моей сексуальной жизни.  
Порой месяцами ничего не получалось! Хорошо, что вовремя узнал про РЕКСАТАЛ
Это отличное средство восстановило мне все ниже пояса. Стоит так, что теперь никакие нервы мне не помеха!"</div>
            <div class="slider__name">Олег, 35 лет</div>
          </div>
      </div>
    </div>
  </section>


  <section class="work">
    <div class="work__wrap">
      <div class="work__title">Закажите Рексатал <span class="work__title--accent">в три шага:</span></div>
      <div class="work__block">
          <div class="work__item">
            <img src="img/work__pic1.png" alt="" class="work__pic">
            <div class="work__text">Заполните форму
заказа ниже</div>
          </div>
          <div class="work__item">
            <img src="img/work__pic2.png" alt="" class="work__pic">
            <div class="work__text">Дождитесь звонка оператора для подтверждения заказа</div>
          </div>
          <div class="work__item garanty">
            <img src="img/work__pic3.png" alt="" class="work__pic">
            <div class="work__text">Мы работаем БЕЗ ПРЕДОПЛАТ! 
Оплачивайте заказ только при получении </div>
              <div class="garanty__text">Гарантируем конфиде-<br>нциальность</div>
          </div>
      </div>
    </div>
  </section>


  <section class="header">
    <div class="header__wrap">
      <div class="header__title">
        <span class="header__title--big">Рексатал</span>
        <span class="header__title--small">Активируйте <span class="header__title--accent">мощную потенцию<br></span> в любом возрасте!</span>
      </div>
      <div class="header__block">
        <div class="header__descr">Первый природный <span class="header__descr--accent">активатор естественной потенции</span> без вреда для здоровья и побочных эффектов!</div>
        <div class="header__list">
          <div class="header__item">Твердая и устойчивая <span class="header__item--accent">эрекция</span></div>
          <div class="header__item">Сильное сексуальное <span class="header__item--accent">желание</span></div>
          <div class="header__item"><span class="header__item--accent">Выносливость и контроль</span> эякуляции</div>
        </div>
        <div class="header__pic">
          <img src="product.png" style='max-width:290px' alt="" class="header__img">
          <div class="header__action">Упаковок по акции осталось: <span class="header__action--accent"><span class="pack_count"></span> шт</span></div>
          <div class="stamps header__stamps">
            <div class="stamps__item">
              <div class="stamps__text">Повышает <b>качество сексуальной
жизни</b> миллионов мужчин!
              </div>
            </div>
          </div>
        </div>
      </div>

      <form action="" method="POST" class="form header__form order_form" id="bottom">
        <div class="form__title">Оформите заказ<br> пока <span class="form__title--accent">действует акция!*</span></div>
        <div class="price">
          <span class="price__text" style="font-size: 19px;">Старая цена</span> <span class="price_main"><del><?= $oldPriceHtml ?>  <?= $currencyDisplayHtml ?></del> </span><br>
		  <span class="price__text" style="font-size: 30px;">Цена по акции:</span> <span class="price_main"><?= $newPriceHtml ?> <?= $currencyDisplayHtml ?> </span>
        </div>
        <label class="form__label">Выберите страну</label>
        <?= countrySelect() ?>
        <label class="form__label">Введите Ф.И.О.</label>
        <input class="form__input" type="text" name="name">
        <label class="form__label">Введите номер телефона</label>
        <input class="form__input" type="tel" name="phone">
        <button class="btn form__btn">Заказать</button>
          <div class="form__action">*при заказе комплексной программы</div>
      </form>

    </div>
  </section>
  <center style="margin: 30px auto"><?= footer() ?></center>

  <script type="text/javascript">
    $(function(){
            $("a[href^='#']").click(function(){
                    var _href = $(this).attr("href");
                    $("html, body").animate({scrollTop: $(_href).offset().top+"px"});
                    return false;
            });
    });
  </script>

  <script>//обратный счетчик товара 
    $(function(){
      var timerIdPackCountNumber = 49;
      $('.pack_count').html(timerIdPackCountNumber);
      
         var timerIdPackCount = setTimeout(function tick() {
          timerIdPackCountNumber--;
          $('.pack_count').html(timerIdPackCountNumber);
          if(timerIdPackCountNumber > 5){
          timerIdPackCount = setTimeout(tick, 60000);
          }
        }, 0);           
  
    })
  </script>



</body>

</html>
