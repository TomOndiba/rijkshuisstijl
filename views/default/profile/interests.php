<?php
  $user = elgg_get_page_owner_entity();
  if (!$user) 
  {
    register_error(elgg_echo("profile:notfound"));
    forward();
  }

  $username = elgg_extract("username", $vars);
  $interests = array(true, false, false, false, false);

  $notifications = array(true, false);

  $targetUser = get_user_by_username($username);
  if (!$targetUser) 
  {
    register_error(elgg_echo("profile:notfound"));
    forward();
  }

  if (isset($targetUser->notifications))
  {
    for ($i = 0; $i < max(count($targetUser->notifications), count($notifications)); $i++)
      $notifications[$i] = $targetUser->notifications[$i] != "0";
  }

  if (isset($targetUser->interests))
  {
    for ($i = 0; $i < max(count($targetUser->interests), count($interests)); $i++)
      $interests[$i] = $targetUser->interests[$i] != "0";
  }

  $editable = $targetUser->canEdit();
?>

<script type="text/javascript">
  var gUsername = '<?php echo $username ?>';
</script>

<div class="rhs-container">
  <div class="rhs-profile-blocks">
    <div class="rhs-profile-block">
      <div class="rhs-row">
        <div class="rhs-col-md-7">
          <h2 class="rhs-profile-block__title">Hier kunt u uw interesses aangeven waardoor informatie voor u op maat wordt gefilterd in het forum en nieuws.</h2>
        </div>
        <div class="rhs-col-md-1"></div>
        <div class="rhs-col-md-4">
          <p class="rhs-form__element rhs-form__element--small-padding">
            <label for="interest-1" class="rhs-checkbox-switch">
              <input type="checkbox" id="interest-1" name="interest-1" <?php echo $interests[0] ? "checked" : "" ?> class="rhs-checkbox-switch__input"><span class="rhs-checkbox-switch__placeholder"></span>Inkomstenbelasting
            </label>
            <label for="interest-2" class="rhs-checkbox-switch">
              <input type="checkbox" id="interest-2" name="interest-2" <?php echo $interests[1] ? "checked" : "" ?> class="rhs-checkbox-switch__input"><span class="rhs-checkbox-switch__placeholder"></span>Toeslagen
            </label>
            <label for="interest-3" class="rhs-checkbox-switch">
              <input type="checkbox" id="interest-3" name="interest-3" <?php echo $interests[2] ? "checked" : "" ?> class="rhs-checkbox-switch__input"><span class="rhs-checkbox-switch__placeholder"></span>Loonheffingen
            </label>
            <label for="interest-4" class="rhs-checkbox-switch">
              <input type="checkbox" id="interest-4" name="interest-4" <?php echo $interests[3] ? "checked" : "" ?> class="rhs-checkbox-switch__input"><span class="rhs-checkbox-switch__placeholder"></span>Omzetbelasting
            </label>
            <label for="interest-5" class="rhs-checkbox-switch">
              <input type="checkbox" id="interest-5" name="interest-5" <?php echo $interests[4] ? "checked" : "" ?> class="rhs-checkbox-switch__input"><span class="rhs-checkbox-switch__placeholder"></span>Vennootschapsbelasting
            </label>
          </p>
        </div>
      </div>
    </div>
    <div class="rhs-profile-block">
      <div class="rhs-row">
        <div class="rhs-col-sm-12">
          <h2 class="rhs-profile-block__title">Notificaties </h2>
          <p class="rhs-form__element rhs-form__element--no-padding">
            <label for="option-1" class="rhs-checkbox rhs-checkbox--theme">
              <input type="checkbox" id="option-1" name="options-1" <?php echo $notifications[0] ? "checked" : "" ?> class="rhs-checkbox__input js-validateCheckbox"><span class="rhs-checkbox__placeholder"></span>Ontvang een melding als iemand op jou reageert
            </label>
          </p>
          <p class="rhs-form__element rhs-form__element--no-padding">
            <label for="option-2" class="rhs-checkbox rhs-checkbox--theme">
              <input type="checkbox" id="option-2" name="options-2" <?php echo $notifications[1] ? "checked" : "" ?> class="rhs-checkbox__input"><span class="rhs-checkbox__placeholder"></span>Ik wil de site nieuwsbrief ontvangen
            </label>
          </p>
        </div>
      </div>
    </div>
    <div class="rhs-profile-block rhs-profile-block--small-bottom-padding">
      <div class="rhs-row">
        <div class="rhs-col-sm-12">
          <h2 class="rhs-profile-block__title">Je e-mailoverzicht instellen </h2>
        </div>
      </div>
      <div class="rhs-row">
        <div class="rhs-col-md-4 rhs-col-sm-6">
          <p class="rhs-form__element">
            <label class="rhs-form__label"><span class="rhs-form__label-text">Inkomstenbelasting</span>
              <select name="thema" id="inkomstenbelasting" data-label="custom" class="selecter-default">
                <option value="" disabled>Geef uw voorkeur</option>
                <option value="1">Geen</option>
                <option value="2" selected="selected">Dagelijks</option>
                <option value="3">Wekelijks</option>
                <option value="4">Tweewekelijks</option>
                <option value="4">Maandelijks</option>
              </select>
            </label>
          </p>
          <p class="rhs-form__element rhs-form__element--small-padding">
            <label class="rhs-form__label"><span class="rhs-form__label-text">Open Forum</span>
              <select name="thema" id="open-forum" data-label="custom" class="selecter-default">
                <option value="" disabled>Geef uw voorkeur</option>
                <option value="1">Geen</option>
                <option value="2" selected="selected">Dagelijks</option>
                <option value="3">Wekelijks</option>
                <option value="4">Tweewekelijks</option>
                <option value="4">Maandelijks</option>
              </select>
            </label>
          </p>
        </div>
        <div class="rhs-col-md-4 rhs-col-sm-6">
          <p class="rhs-form__element">
            <label class="rhs-form__label"><span class="rhs-form__label-text">Loonheffingen</span>
              <select name="thema" id="loonheffingen" data-label="custom" class="selecter-default">
                <option value="" disabled>Geef uw voorkeur</option>
                <option value="1">Geen</option>
                <option value="2" selected="selected">Dagelijks</option>
                <option value="3">Wekelijks</option>
                <option value="4">Tweewekelijks</option>
                <option value="4">Maandelijks</option>
              </select>
            </label>
          </p>
          <p class="rhs-form__element rhs-form__element--small-padding">
            <label class="rhs-form__label"><span class="rhs-form__label-text">Toeslagen</span>
              <select name="thema" id="toeslagen" data-label="custom" class="selecter-default">
                <option value="" disabled>Geef uw voorkeur</option>
                <option value="1">Geen</option>
                <option value="2" selected="selected">Dagelijks</option>
                <option value="3">Wekelijks</option>
                <option value="4">Tweewekelijks</option>
                <option value="4">Maandelijks</option>
              </select>
            </label>
          </p>
        </div>
        <div class="rhs-col-md-4">
          <div class="rhs-row">
            <div class="rhs-col-sm-6 rhs-col-md-12">
              <p class="rhs-form__element">
                <label class="rhs-form__label"><span class="rhs-form__label-text">Omzetbelasting</span>
                  <select name="thema" id="omzetbelasting" data-label="custom" class="selecter-default">
                    <option value="" disabled>Geef uw voorkeur</option>
                    <option value="1">Geen</option>
                    <option value="2" selected="selected">Dagelijks</option>
                    <option value="3">Wekelijks</option>
                    <option value="4">Tweewekelijks</option>
                    <option value="4">Maandelijks</option>
                  </select>
                </label>
              </p>
            </div>
            <div class="rhs-col-sm-6 rhs-col-md-12">
              <p class="rhs-form__element rhs-form__element--small-padding">
                <label class="rhs-form__label"><span class="rhs-form__label-text">Vennootschapsbelasting</span>
                  <select name="thema" id="vennootschapsbelasting" data-label="custom" class="selecter-default">
                    <option value="">Geef uw voorkeur</option>
                    <option value="1">Geen</option>
                    <option value="2">Dagelijks</option>
                    <option value="3">Wekelijks</option>
                    <option value="4">Tweewekelijks</option>
                    <option value="4">Maandelijks</option>
                  </select>
                </label>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>