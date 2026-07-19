<form name="frmmain" action="index.php" method="post" enctype="multipart/form-data">

  <input type="hidden" name="m" value="config" />

  <input type="hidden" name="op" value="update" />

  <div id="view">

    <table width="100%" cellpadding="5" style="border:1px solid #F2F2F2; padding-left:5" id="main">

      <tr>

        <td colspan="2" style="padding-left:10;">
          <h2>Cấu hình hệ thống</h2>
        </td>

      </tr>



      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">{$Web_title}</td>

        <td style="border-bottom:1ps solid #f2f2f2">

          <input type="text" class="form-control" name="web_title" style="width:100%;" value="{$arr.web_title}" />
        </td>

      </tr>



      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">{$Email}</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="text" class="form-control" name="email"
            style="width:100%;" value="{$arr.email}" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">{$Yahoo_online}</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="ymsupport"
            style="width:100%;" value="{$arr.ymsupport}" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Nick skype</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="skype"
            style="width:100%;" value="{$arr.skype}" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Facebook</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="hotline"
            style="width:100%;" value="{$arr.hotline}" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Sales Online</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="form-control" class="form-control" name="tel"
            style="width:100%;" value="{$arr.tel}" /></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Meta description</td>

        <td width="100%" style="border-bottom:1ps solid #f2f2f2"><textarea name="site_name" class="form-control"
            style="width:100%; height:80;">{$arr.site_name}</textarea></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">{$Meta_key}</td>

        <td style="border-bottom:1ps solid #f2f2f2"><textarea name="meta_keys" class="form-control"
            style="width:100%; height:80;">{$arr.meta_keys}</textarea></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">{$Address}</td>

        <td style="border-bottom:1ps solid #f2f2f2"><textarea name="address" class="form-control"
            style="width:100%; height:80;">{$arr.address}</textarea></td>

      </tr>



      <tr>

        <td style="border-bottom:1ps solid #f2f2f2" nowrap="nowrap">{$Contact}</td>

        <td style="border-bottom:1ps solid #f2f2f2"><textarea name="des" class="form-control"
            style="width:100%; height:80;">{$arr.des}</textarea></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2" nowrap="nowrap">Google Maps</td>

        <td style="border-bottom:1ps solid #f2f2f2"><textarea name="support" class="form-control"
            style="width:100%; height:80;">{$arr.support}</textarea></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">{$Theme}</td>

        <td style="border-bottom:1ps solid #f2f2f2"><select name="theme" class="form-select">
            <option value="default">default</option>
          </select></td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">{$Language}</td>

        <td style="border-bottom:1ps solid #f2f2f2">{getCboLanguage lang=$lang}</td>

      </tr>

      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">Rewrite URL?</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="checkbox" name="rewrite_url" {if
            $arr.rewrite_url=='htaccess' } checked="checked" {/if} /></td>

      </tr>

      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% tối đa thanh toán bằng điểm thẻ tiêu dùng</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="card_payment_percent" style="width:100px;"
            value="{if $arr.card_payment_percent==''}100{else}{$arr.card_payment_percent}{/if}" />
          <!-- <em>(0-100, mục 3 BUSINESS_RULES.md - đơn hàng chỉ được thanh toán tối đa % này bằng điểm thẻ tiêu dùng)</em> -->
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% quỹ chia hoa hồng trích vào quỹ vận hành</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="operating_fund_percent" style="width:100px;"
            value="{if $arr.operating_fund_percent==''}10{else}{$arr.operating_fund_percent}{/if}" />
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% quỹ chia hoa hồng trích vào Tích lũy tiêu dùng</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="accumulated_consumption_percent" style="width:100px;"
            value="{if $arr.accumulated_consumption_percent==''}10{else}{$arr.accumulated_consumption_percent}{/if}" />
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% quỹ chia hoa hồng trích vào thưởng tiêu dùng tuần hoàn</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="card_recurring_percent" style="width:100px;"
            value="{if $arr.card_recurring_percent==''}16{else}{$arr.card_recurring_percent}{/if}" />
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; width:320px !important; min-width:320px !important; max-width:320px !important;">% thưởng tiêu dùng tuần hoàn chia cho tuyến trên<br /><small style="color:#6b7280; font-weight:normal;">(còn lại vào Quỹ tiêu dùng tuần hoàn công ty)</small></td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <input type="text" class="form-control" name="recurring_consumption_ancestor_percent" style="width:100px;"
            value="{if $arr.recurring_consumption_ancestor_percent==''}70{else}{$arr.recurring_consumption_ancestor_percent}{/if}" />
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1ps solid #f2f2f2; vertical-align:top;">Tỉ lệ % hoa hồng theo tầng F1-F8<br />(mục 4 &amp; 6 BUSINESS_RULES.md)</td>
        <td style="border-bottom:1ps solid #f2f2f2">
          <table class="table table-bordered" style="width:auto;">
            <tr>
              <th>Tầng</th>
              <th>Hoa hồng sơ đồ trực tiếp (%)</th>
              <th>Hoa hồng cây điều tầng (%)</th>
            </tr>
            <tr>
              <td>F1</td>
              <td><input type="text" class="form-control" name="f1" style="width:90px;" value="{if $arr.f1==''}16{else}{$arr.f1*100}{/if}" /></td>
              <td><input type="text" class="form-control" name="spillover_f1" style="width:90px;" value="{if $arr.spillover_f1==''}3{else}{$arr.spillover_f1*100}{/if}" /></td>
            </tr>
            <tr>
              <td>F2</td>
              <td><input type="text" class="form-control" name="f2" style="width:90px;" value="{if $arr.f2==''}2{else}{$arr.f2*100}{/if}" /></td>
              <td><input type="text" class="form-control" name="spillover_f2" style="width:90px;" value="{if $arr.spillover_f2==''}3{else}{$arr.spillover_f2*100}{/if}" /></td>
            </tr>
            <tr>
              <td>F3</td>
              <td><input type="text" class="form-control" name="f3" style="width:90px;" value="{if $arr.f3==''}2{else}{$arr.f3*100}{/if}" /></td>
              <td><input type="text" class="form-control" name="spillover_f3" style="width:90px;" value="{if $arr.spillover_f3==''}3{else}{$arr.spillover_f3*100}{/if}" /></td>
            </tr>
            <tr>
              <td>F4</td>
              <td><input type="text" class="form-control" name="f4" style="width:90px;" value="{if $arr.f4==''}2{else}{$arr.f4*100}{/if}" /></td>
              <td><input type="text" class="form-control" name="spillover_f4" style="width:90px;" value="{if $arr.spillover_f4==''}3{else}{$arr.spillover_f4*100}{/if}" /></td>
            </tr>
            <tr>
              <td>F5</td>
              <td><input type="text" class="form-control" name="f5" style="width:90px;" value="{if $arr.f5==''}2{else}{$arr.f5*100}{/if}" /></td>
              <td><input type="text" class="form-control" name="spillover_f5" style="width:90px;" value="{if $arr.spillover_f5==''}3{else}{$arr.spillover_f5*100}{/if}" /></td>
            </tr>
            <tr>
              <td>F6</td>
              <td><input type="text" class="form-control" name="f6" style="width:90px;" value="{if $arr.f6==''}2{else}{$arr.f6*100}{/if}" /></td>
              <td><input type="text" class="form-control" name="spillover_f6" style="width:90px;" value="{if $arr.spillover_f6==''}3{else}{$arr.spillover_f6*100}{/if}" /></td>
            </tr>
            <tr>
              <td>F7</td>
              <td><input type="text" class="form-control" name="f7" style="width:90px;" value="{if $arr.f7==''}2{else}{$arr.f7*100}{/if}" /></td>
              <td><input type="text" class="form-control" name="spillover_f7" style="width:90px;" value="{if $arr.spillover_f7==''}3{else}{$arr.spillover_f7*100}{/if}" /></td>
            </tr>
            <tr>
              <td>F8</td>
              <td><input type="text" class="form-control" name="f8" style="width:90px;" value="{if $arr.f8==''}2{else}{$arr.f8*100}{/if}" /></td>
              <td><input type="text" class="form-control" name="spillover_f8" style="width:90px;" value="{if $arr.spillover_f8==''}3{else}{$arr.spillover_f8*100}{/if}" /></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>

        <td style="border-bottom:1ps solid #f2f2f2">&nbsp;</td>

        <td style="border-bottom:1ps solid #f2f2f2"><input type="submit" value="{$Update}" class="btn btn-primary" />
        </td>

      </tr>

    </table>

  </div>

</form>