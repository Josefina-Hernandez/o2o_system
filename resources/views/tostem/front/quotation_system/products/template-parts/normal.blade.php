<div id="product-name">
	<div v-if="ctg_id != 2">
		<div class="option-group" v-if="product_name" data-group-name="product_name">
			<div><button class="btn c-btn large black c-label">@{{ product_name }}</button></div>
		</div>
	</div>
</div>

<template v-if="Object.keys(itemDisplay).length > 0">
	<div id="list-item-display">
		<div class="option-group" v-for="(item, index) in mItemDisplay" style="flex-wrap: nowrap;">
			<div>
				<button class="btn c-btn large black c-label">
					<span>@{{ item }}</span>
				</button>
			</div>
			<ul class="option" v-if="index == 0 && folding_door_image_manual_description == true">
				<li>
					<img :src="'/tostem/img/data/Special/we_70_folding_door_manual_' + model_id +'.jpg'" class="img-responsive">
				</li>
			</ul>
		</div>
	</div>
</template>

<template v-if="Object.keys(specs.select).length > 0">
	<div id="list-spec-select">
		<div
			v-for="(objSpec, specCode, index) in specs.select"
			:class="['option-group', {'d-none' : objSpec.data.length == 1 && !configAlwayDisplaySpecItem.includes(specCode)}]"
			:data-group-name="specCode">
			<template v-if="specCode == 'spec29' && spec29_special">
				<div>
					<button class="btn c-btn large black c-label">
						<span>@{{ getSpecLabel(specCode) }}</span>
					</button>
				</div>
				<ul class="option">
					<li
						v-for="item in objSpec.data"
						@click="selectSpec(specCode, item)"
						:data-spec-id="item"
						class="mullion-transom-item"
						>
						<a :class="[{'active' : Object.keys(spec_selected).includes(specCode) && spec_selected[specCode] == item}]">
							<img class="" :src="'/tostem/img/data/' + objSpec.img[item][0] + '/' + objSpec.img[item][1]">
						</a>
					</li>
				</ul>
			</template>
			<template v-else>
				<template v-if="objSpec.data.length == 1 && configAlwayDisplaySpecItem.includes(specCode)">
					<div>
						<button class="btn c-btn large black c-label">
							<span>@{{ getSpecLabel(specCode) }}</span>
						</button>
					</div>
					<ul class="option">
						<li
							v-for="item in objSpec.data"
							:data-spec-id="item"
							>
							<button class="black btn c-btn">@{{ list_spec_trans[item] }}</button>
						</li>
					</ul>
				</template>

				<template v-else-if="objSpec.data.length == 2 || checkShowSpecButton(specCode)">
					<div>
						<button class="btn c-btn large black c-label">
							<span>@{{ getSpecLabel(specCode) }}</span>
						</button>
					</div>
					<ul class="option">
						<li
							v-for="item in objSpec.data"
							@click="selectSpec(specCode, item)"
							:data-spec-id="item"
							>
							<button :class="[{'black' : Object.keys(spec_selected).includes(specCode) && spec_selected[specCode] == item}, 'btn c-btn']">@{{ list_spec_trans[item] }}</button>
						</li>
					</ul>
					<span v-if="specCode == 'spec4'" class="spec4-img">
						<div>
							<span class="img-description">
								<img src="{{ asset('/tostem/img/data/1st.png') }}">
								<div class="des">For 1st floor</div>
							</span>
							<span class="img-description">
								<img src="{{ asset('/tostem/img/data/2st.png') }}">
								<div class="des">2nd floor and above</div>
							</span>
						</div>
					</span>
					<span v-if="specCode == 'spec10' && spec10_description_rule == true"
						style="
							color: red;
							display: inline-block;
							padding-left: 1.5rem;
						"
					>
						{{ __('screen-select.spec10_description_rule') }}
					</span>

					<span v-if="specCode == config_picture_show_r_movement"
						class="show_r_movement"
					>
						{{ __('screen-select.config_picture_show_r_movement_msg') }}
					</span>

					<image-description :spec-code="specCode" :config="configDisplayImageDescription"/>
				</template>

				<template v-else-if="objSpec.data.length > 2">
					<div>
						<button class="btn c-btn large black c-label">
							<span>@{{ getSpecLabel(specCode) }}</span>
						</button>
					</div>
					<ul class="option">
						<li>
							<select @change="selectSpecOnchange($event)" :data-spec-code="specCode" v-model="objSpec.active">
								<option value="">{{ __('screen-select.choose') }}</option>
								<option
									v-for="item in objSpec.data"
		    						:class="[{'black' : objSpec.data.length == 1}, 'btn c-btn large']"
		    						:value="item"
		    						>@{{ list_spec_trans[item] }}
		    					</option>
							</select>
						</li>
					</ul>
					<span v-if="specCode == 'spec4'" class="spec4-img">
						<div>
							<span class="img-description">
								<img src="{{ asset('/tostem/img/data/1st.png') }}">
								<div class="des">For 1st floor</div>
							</span>
							<span class="img-description">
								<img src="{{ asset('/tostem/img/data/2st.png') }}">
								<div class="des">2nd floor and above</div>
							</span>
						</div>
					</span>
					<span v-if="specCode == config_picture_show_r_movement"
						class="show_r_movement"
					>
						{{ __('screen-select.config_picture_show_r_movement_msg') }}
					</span>

					<image-description :spec-code="specCode" :config="configDisplayImageDescription" />
				</template>
			</template>
		</div>
	</div>
</template>

<template v-if="Object.keys(specs.disable).length > 0">
	<div id="list-spec-disable">
		<div v-for="(objSpec, specCode, index) in specs.disable">
			<template v-if="objSpec.data.length == 1 && configAlwayDisplaySpecItem.includes(specCode)">
				<div class="option-group" :data-group-name="specCode">
					<div>
						<button class="btn c-btn large black c-label">
							<span>@{{ getSpecLabel(specCode) }}</span>
						</button>
					</div>
					<ul class="option">
						<li
							v-for="item in objSpec.data"
							:data-spec-id="item"
							>
							<button class="black btn c-btn" disabled>@{{ list_spec_trans[item] }}</button>
						</li>
					</ul>
				</div>
			</template>

			<template v-else-if="objSpec.data.length == 2 || checkShowSpecButton(specCode)">
				<div :class="['option-group', {'d-none' : objSpec.data.length == 1}]" :data-group-name="specCode">
					<div>
						<button class="btn c-btn large black c-label">
							<span>@{{ getSpecLabel(specCode) }}</span>
						</button>
					</div>
					<ul class="option">
						<li
							v-for="item in objSpec.data"
							:data-spec-id="item"
							>
							<button class="btn c-btn" disabled>@{{ list_spec_trans[item] }}</button>
						</li>
					</ul>
					<span v-if="specCode == config_picture_show_r_movement"
						class="show_r_movement"
					>
						{{ __('screen-select.config_picture_show_r_movement_msg') }}
					</span>
				</div>
			</template>

			<template v-else-if="objSpec.data.length > 2">
				<div :class="['option-group', {'d-none' : objSpec.data.length == 1}]" :data-group-name="specCode">
					<div>
						<button class="btn c-btn large black c-label">
							<span>@{{ getSpecLabel(specCode) }}</span>
						</button>
					</div>
					<ul class="option">
						<li>
							<select disabled>
								<option value="">{{ __('screen-select.choose') }}</option>
							</select>
						</li>
					</ul>
					<span v-if="specCode == config_picture_show_r_movement"
						class="show_r_movement"
					>
						{{ __('screen-select.config_picture_show_r_movement_msg') }}
					</span>
				</div>
			</template>
		</div>
	</div>
</template>

<template v-if="Object.keys(colors).length > 0">
	<div id="color-list">
		<div class="option-group">
			<div><button class="btn c-btn large black c-label">{{ __('screen-select.color') }} <span v-if="color_name">- @{{ color_name }}</span></button></div>
			<ul class="option color-list">
				<li v-for="(color, propertyName, index) in colors" :key="propertyName">
					<a @click="selectColor(propertyName)" :m-color-id="color.m_color_id">
						<img :class="['color-img', {'active': color.m_color_id == color_id}]" :src="'/tostem/img/data/' + color.img_path + '/' + color.img_name">
					</a>
				</li>
			</ul>
		</div>
	</div>
</template>

<template id="list-size" v-if="size.data_width.length > 0 || size.data_height.length > 0">
	<div class="option-group">
		<div><button class="btn c-btn large black c-label">{{ __('screen-select.size') }}</button></div>
		<ul class="option">
			<li v-if="size.data_width.length > 0">
				{{-- Edit BP_O2OQ11 HUNGLM - 20200925 --}}
					<span v-if="model_id == 54 || model_id == 55">{{ __('screen-select.length') }}</span>
					<span v-else>{{ __('screen-select.width') }}:</span>

					<template v-if="is_fence">
						<input
							type="text"
							class="form-control fence-input-width"
							maxlength="6"
							:disabled="checkDisabledWidth"
							@keypress="allownumericwithdecimal"
							@keyup="inputFenceWidth($event)"
							@focus="removeFormatNumber"
							@blur="formatWidthFence"
							ref="fence_width"
						>
					</template>

					<template v-else>
						<select
							@change="selectWidthOnChange($event)"
							v-model="size.width"
							:disabled="checkDisabledWidth"
							class="select-size"
							>
							<option value="null">{{ __('screen-select.choose') }}</option>
							<option v-for="item in size.data_width" :value="item">@{{ formatNumber(item) }}</option>
						</select>
					</template>
					<span class="unit">{{ __('screen-cart.mm') }}</span> {{-- Edit BP_O2OQ-7 hainp 20200727 --}}
				{{-- Edit BP_O2OQ11 HUNGLM - 20200925 --}}
			</li>

			<template v-if="is_fence">
				<li>
					{{-- Edit BP_O2OQ11 HUNGLM - 20200925 --}}
						{{ __('screen-select.height') }}:
						<select
							@change="selectHeightOnChange($event)"
							v-model="size.height"
							:disabled="checkDisabledHeight"
							class="select-size"
							>
							<option value="null">{{ __('screen-select.choose') }}</option>
							<option v-for="item in size.data_height" :value="item">@{{ formatNumber(item) }}</option>
						</select>
						{{ __('screen-cart.mm') }} {{-- Edit BP_O2OQ-7 hainp 20200727 --}}
					{{-- Edit BP_O2OQ11 HUNGLM - 20200925 --}}
				</li>
			</template>

			<template v-else>
				<li v-if="size.data_height.length > 0">
					{{-- Edit BP_O2OQ11 HUNGLM - 20200925 --}}
						{{ __('screen-select.height') }}:
						<select
							@change="selectHeightOnChange($event)"
							v-model="size.height"
							:disabled="checkDisabledHeight"
							class="select-size"
							>
							<option value="null">{{ __('screen-select.choose') }}</option>
							<option v-for="item in size.data_height" :value="item">@{{ formatNumber(item) }}</option>
						</select>
						{{ __('screen-cart.mm') }} {{-- Edit BP_O2OQ-7 hainp 20200727 --}}
					{{-- Edit BP_O2OQ11 HUNGLM - 20200925 --}}
				</li>
			</template>
		</ul>
	</div>
</template>
<template v-if="Object.keys(options).length > 0">
	<div id="list-option">
		<div
			v-for="(value, optionCode, index) in options"
			:data-group-name="optionCode"
			:class="['option-group', {
				'd-none' : value.length == 1 && 'option5' != optionCode
			}]"  
		>

			<template v-if="value.length == 1 && 'option5' == optionCode">
				<div>
					<button class="btn c-btn large black c-label">
						<span>@{{ getSpecLabel(optionCode, 'option') }}</span>
					</button>
				</div>
				<ul class="option">
					<li
						v-for="item in value"
						@click="selectSpecOption(optionCode, item)"
						:data-spec-id="item"
					>
						<button
							:class="[{'black' : Object.keys(option_selected).includes(optionCode) && option_selected[optionCode] == item}, 'btn c-btn']"
							:disabled="checkDisabledOption"
							>@{{ list_spec_trans[item] }}
						</button>
					</li>
					<span v-if="optionCode == 'option7' && product_id == 10"
						class="show_msg_flat_sill"
					>
						{{ __('screen-select.flat_sill_attachment_msg') }}
					</span>
					<span v-if="optionCode == 'option9' && product_id == 10"
						class="show_msg_limit_arm"
					>
						{{ __('screen-select.limit_arm_msg') }}
					</span>
				</ul>
			</template>

			<template v-if="value.length == 2 || checkShowOptionButton(value, optionCode)">
				<div>
					<button class="btn c-btn large black c-label">
						<span>@{{ getSpecLabel(optionCode, 'option') }}</span>
					</button>
				</div>
				<ul class="option">
					<li
						v-for="item in value"
						@click="selectSpecOption(optionCode, item)"
						:data-spec-id="item"
					>   
						<button
							:class="[{'black' : Object.keys(option_selected).includes(optionCode) && option_selected[optionCode] == item}, 'btn c-btn']"
							:disabled="checkDisabledOption"
							>@{{ list_spec_trans[item] }}
						</button>
					</li>
					<span v-if="optionCode == 'option7' && product_id == 10"
						class="show_msg_flat_sill"
					>
						{{ __('screen-select.flat_sill_attachment_msg') }}
					</span>
					<span v-if="optionCode == 'option9' && product_id == 10"
						class="show_msg_limit_arm"
					>
						{{ __('screen-select.limit_arm_msg') }}
					</span>
				</ul>
			</template>

			<template v-else-if="value.length > 2">
				<div>
					<button class="btn c-btn large black c-label">
						<span>@{{ getSpecLabel(optionCode, 'option') }}</span>
					</button>
				</div>
				<ul class="option">
					<li>
						<select @change="selectSpecOptionOnchange($event)" :disabled="checkDisabledOption" :data-spec-code="optionCode">
							<option value="null">{{ __('screen-select.choose') }}</option>
							<option
								v-for="item in value"
	    						:class="[{'black' : value.length == 1}, 'btn c-btn large']"
	    						:value="item"
	    						>@{{ list_spec_trans[item] }}
	    					</option>
						</select>
					</li>
					<span v-if="optionCode == 'option7' && product_id == 10"
						class="show_msg_flat_sill"
					>
						{{ __('screen-select.flat_sill_attachment_msg') }}
					</span>
					<span v-if="optionCode == 'option9' && product_id == 10"
						class="show_msg_limit_arm"
					>
						{{ __('screen-select.limit_arm_msg') }}
					</span>
				</ul>
			</template>
		</div>
	</div>
</template>