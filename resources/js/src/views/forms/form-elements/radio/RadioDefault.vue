<!-- =========================================================================================
    File Name: RadioDefault.vue
    Description: Rendering default radio
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <vx-card title="Default" code-toggler>

        <p>To implement a radio button you just add the <code>vs-radio</code> component and add a <code>v-model</code></p>

        <vs-alert icon="warning" active="true" color="warning" class="mt-5">
            <span>The <strong>Radio Button</strong> is always going to replace the current value.</span>
        </vs-alert>

        <ul class="demo-alignment">
            <li>
                <vs-radio v-model="radios1" vs-value="luis">Luis</vs-radio>
            </li>
            <li>
                <vs-radio v-model="radios1" vs-value="carols">Carols</vs-radio>
            </li>
            <li>
                <vs-radio v-model="radios1" vs-value="summer">Summer</vs-radio>
            </li>
            <li>
                <vs-radio disabled="true" v-model="radios1" vs-value="lyon">Lyon - disabled</vs-radio>
            </li>
            <li class="op-block">
                {{radios1}}
            </li>
        </ul>
    </vx-card>
</template>

<script>
export default {
  data () {
    return {
      radios1: 'luis'
    }
  }
}
</script>
