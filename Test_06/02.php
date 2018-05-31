<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/12/14
 * Time: 下午9:04
 */

/* VUE级连测试 */
?>

<div class="add_area">
    <label for="add_credit" class="city_text">请选择</label>
    <select v-model="city_id" id="city_id" name="city_id" :value="current_user.city_id">
        <option v-if="current_user.city_id < 1" value="0">请选择</option>
        <option v-for="city, city_id in cities[current_user.province_id]" :value="city_id">${city}</option>
    </select>
</div>


<script src="https://unpkg.com/vue"></script>
<script>





</script>

