<div id="product-name">
	<div class="option-group" v-if="product_name" data-group-name="product_name">
		<div><button class="btn c-btn large black c-label">@{{ product_name }}</button></div>
	</div>
</div>

<template v-if="Object.keys(itemDisplay).length > 0">
	<div id="list-item-display">
		<div class="option-group" v-for="item in mItemDisplay">
			<div>
				<button class="btn c-btn large black c-label">
					<span>@{{ item }}</span>
				</button>
			</div>
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

<template v-if="Object.keys(specs.select).length > 0">
	<div id="list-spec-select">
		<div v-for="(objSpec, specCode, index) in specs.select">
			<template v-if="specCode == 'spec55'"
			:style="specCode == 'spec55' ? 'position: relative !important;' : ''">  <!--Added this line by An Lu AKT on 2024-09-12-->
				<div :class="['option-group', {'d-none' : objSpec.data.length == 1}]" :data-group-name="specCode">
					<div class="spec55-flex-container" :style="divStyle"> <!--Added this line by An Lu AKT on 2024-09-12-->
						<button class="btn c-btn large black c-label">
							<span>@{{ getSpecLabel(specCode) }}</span>
						</button>
						<button id="btn-standard" @click="selectStandardHandler" style="background: #FFFFFF !important; color: initial !important; cursor: pointer; margin-left: 5px !important; padding: 0.2rem 0.5rem; font-size: 1.3rem; font-weight: 400; width: 12rem; border-radius: 4px; border: 0.1rem solid #ddd;">Standard</button> <!--Added this line by An Lu AKT on 2024-09-12-->
						<button id="btn-digital" @click="selectDigitalHandler" style="background: #FFFFFF !important; color: initial !important; cursor: pointer; margin-left: 15px !important; padding: 0.2rem 0.5rem; font-size: 1.3rem; font-weight: 400; width: 12rem; border-radius: 4px; border: 0.1rem solid #ddd;">Digital</button> <!--Added this line by An Lu AKT on 2024-09-12-->
					</div>
					<ul class="option" style="flex-grow: 2; margin-top: 70px !important;"> <!--Added "style" by An Lu AKT on 2024-09-12-->
						<div> <!--Added this line by An Lu AKT on 2024-09-12-->
							<li
								v-for="handle in target_handler_type"
								@click="selectSpec(specCode, handle.spec55, handle.option4)"
								:data-spec-id="handle.spec55"
								:option4="handle.option4"
								class="frame-type-item handle-type"
								>
								<a v-html="getSpecImage(handle.option4, handle.name)" :class="[{'active' : Object.keys(spec_selected).includes(specCode) && handle_active == handle.option4}]">
									@{{ getSpecImage(handle.option4) }}
									<span>@{{ handle.name }}</span>
								</a>
							</li>
						</div> <!--Added this line by An Lu AKT on 2024-09-12-->
					</ul>
				</div>
			</template> {{-- spec55 --}}
			<template v-else-if="specCode == 'spec53'">
				<div :class="['option-group', {'d-none' : objSpec.data.length == 1}]" :data-group-name="specCode">
					<div>
						<button class="btn c-btn large black c-label">
							<span>@{{ getSpecLabel(specCode) }}</span>
						</button>
					</div>
					<ul class="option" style="flex-grow: 2">
						<li
							v-for="item in objSpec.data"
							@click="selectSpec(specCode, item)"
							:data-spec-id="item"
							class="frame-type-item"
							>
							<a v-html="getSpecImage(item, list_spec_trans[item])" :class="[{'active' : Object.keys(spec_selected).includes(specCode) && spec_selected[specCode] == item}]"></a>
						</li>
					</ul>
				</div>
			</template>
			<template v-else-if="specCode == 'spec51'">
				<div :class="['option-group']" :data-group-name="specCode">
					<div>
						<button class="btn c-btn large black c-label">
							<span>@{{ getSpecLabel(specCode) }}</span>
						</button>
					</div>
					<ul class="option" style="flex-grow: 2">
						<li
							v-for="item in objSpec.data"
							@click="selectSpec(specCode, item)"
							:data-spec-id="item"
							class="type-item"
							>
							<a v-html="getSpecImage(item, list_spec_trans[item])" :class="[{'active' : Object.keys(spec_selected).includes(specCode) && spec_selected[specCode] == item}]"></a>
						</li>
					</ul>
				</div>
			</template>
			<template v-else-if="specCode != 'spec57'">
				<div :class="['option-group', {'d-none' : objSpec.data.length == 1}]" :data-group-name="specCode">
					<template v-if="objSpec.data.length == 2">
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
								<button
									:class="[{'black' : Object.keys(spec_selected).includes(specCode) && spec_selected[specCode] == item}, 'btn c-btn']"
									>@{{ list_spec_trans[item] }}
								</button>
							</li>
						</ul>
						<span v-if="specCode == 'spec54'">
							<img :src="featured_img_spec51" style="max-height: 100px; width: auto;">
						</span>
					</template>
					<template v-else>
						<div>
							<button class="btn c-btn large black c-label">
								<span>@{{ getSpecLabel(specCode) }}</span>
							</button>
						</div>
						<ul class="option">
							<li>
								<select
									@change="selectSpecOnchange($event)"
									:data-spec-code="specCode"
									v-model="objSpec.active"
									>
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
						<span v-if="specCode == 'spec54'">
							<img :src="featured_img_spec51" style="max-height: 100px; width: auto;">
						</span>
					</template>
				</div>
			</template>
		</div>
	</div>
</template>

<template v-if="Object.keys(specs.disable).length > 0">
	<div id="list-spec-disable">
		<div
			v-for="(objSpec, specCode, index) in specs.disable"
			:class="['option-group', {'d-none' : objSpec.data.length == 1 && specCode != 'spec51'}]"
			:data-group-name="specCode">
			<template v-if="specCode == 'spec55'"
			:style="specCode == 'spec55' ? 'position: relative !important;' : ''">  <!--Added this line by An Lu AKT on 2024-09-12-->
				<div class="spec55-flex-container" :style="divStyle"> <!--Added this line by An Lu AKT on 2024-09-12-->
					<button class="btn c-btn large black c-label">
						<span>@{{ getSpecLabel(specCode) }}</span>
					</button>
					<button style="background: #FFFFFF !important; color: #787878 !important; disabled: disabled; cursor: not-allowed; margin-left: 5px !important; padding: 0.2rem 0.5rem; font-size: 1.3rem; font-weight: 400; width: 12rem; border-radius: 4px; border: 0.1rem solid #ddd;">Standard</button> <!--Added this line by An Lu AKT on 2024-09-12-->
					<button style="background: #FFFFFF !important; color: #787878 !important; disabled: disabled; cursor: not-allowed; margin-left: 15px !important; padding: 0.2rem 0.5rem; font-size: 1.3rem; font-weight: 400; width: 12rem; border-radius: 4px; border: 0.1rem solid #ddd;">Digital</button> <!--Added this line by An Lu AKT on 2024-09-12-->
				</div>
				<ul class="option" style="flex-grow: 2; margin-top: 70px !important;"> <!--Added "style" by An Lu AKT on 2024-09-12-->
					<div>  <!--Added this line by An Lu AKT on 2024-09-12-->
						<li
							v-for="handle in handler_type.option4"
							:data-spec-id="handle.spec55"
							:option4="handle.option4"
							class="frame-type-item handle-type"
							>
							<a v-html="getSpecImage(handle.option4, handle.name)"></a>
						</li>
					</div>  <!--Added this line by An Lu AKT on 2024-09-12-->
				</ul>
			</template> {{-- spec55 --}}
			<template v-else-if="specCode == 'spec53'">
				<div>
					<button class="btn c-btn large black c-label">
						<span>@{{ getSpecLabel(specCode) }}</span>
					</button>
				</div>
				<ul class="option" style="flex-grow: 2">
					<li
						v-for="item in objSpec.data"
						:data-spec-id="item"
						class="frame-type-item"
						>
						<a>
							<img class="" src="{{ asset('/tostem/img/data/single-leaf.png') }}" v-if="item == '53.1'">
							<img class="" src="{{ asset('/tostem/img/data/with-sidetlight.png') }}" v-else-if="item == '53.2'">
							<img class="" src="{{ asset('/tostem/img/data/double-leaf.png') }}" v-else-if="item == '53.3'">
							<span>@{{ list_spec_trans[item] }}</span>
						</a>
					</li>
				</ul>
			</template>
			<template v-else-if="specCode == 'spec51'">
				<div>
					<button class="btn c-btn large black c-label">
						<span>@{{ getSpecLabel(specCode) }}</span>
					</button>
				</div>
				<ul class="option" style="flex-grow: 2">
					<li
						v-for="item in objSpec.data"
						:data-spec-id="item"
						class="type-item"
						>
						<a v-html="getSpecImage(item, list_spec_trans[item])"></a>
					</li>
				</ul>
			</template>
			<template v-else-if="specCode == 'spec57'">
				<div>
					<button class="btn c-btn large black c-label">
						<span>@{{ getSpecLabel(specCode) }}</span>
					</button>
				</div>
				<ul class="option" style="flex-grow: 2">
					<li
						v-for="item in objSpec.data"
						:data-spec-id="item"
						class="frame-type-item"
						>
						<a v-html="getSpecImage(item, list_spec_trans[item])"></a>
					</li>
				</ul>
			</template>
			<template v-else>
				<template v-if="objSpec.data.length == 2">
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
					<span v-if="specCode == 'spec54'">
						<img :src="featured_img_spec51" style="max-height: 100px; width: auto;">
					</span>
				</template>

				<template v-else>
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
					<div v-if="specCode == 'spec54'">
						<img :src="featured_img_spec51" style="max-height: 100px; width: auto;">
					</div>
				</template>
			</template>
		</div>
	</div>
</template>

<template v-if="Object.keys(spec_selected).includes('spec53') && spec_selected.spec53 == '53.2' && Object.keys(specs.select).includes('spec57')">
	<div id="side-panel">
		<div class="option-group" data-group-name="spec57">
			<div>
				<button class="btn c-btn large black c-label">
					<span>@{{ getSpecLabel('spec57') }}</span>
				</button>
			</div>
			<ul class="option" style="flex-grow: 2">
				<li
					v-for="item in specs.select.spec57.data"
					v-on:click="selectSpec57(item)"
					:data-spec-id="item"
					:class="['frame-type-item', {'disabled': checkDisabledSidePanel == true}]"
					>
					<a v-html="getSpecImage(item, list_spec_trans[item])" :class="[{'active' : Object.keys(spec_selected).includes('spec57') && spec_selected['spec57'] == item}]">
						@{{ getSpecImage(item) }}
						<span>@{{ list_spec_trans[item] }}</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</template>

<template v-if="size.data_width.length > 0 || size.data_height.length > 0">
	<div id="list-size">
		<div class="option-group">
			<div><button class="btn c-btn large black c-label">{{ __('screen-select.size') }}</button></div>
			<ul class="option">
				<li v-if="size.data_width.length > 0">
					{{-- Edit BP_O2OQ11 HUNGLM - 20200925 --}}
						{{ __('screen-select.width') }}:
						<select
							@change="selectWidthOnChange($event)"
							v-model="size.width"
							:disabled="checkDisabledWidth"
							class="select-size"
							>
							<option value="null">{{ __('screen-select.choose') }}</option>
							<option v-for="item in size.data_width" :value="item">@{{ formatNumber(item) }}</option>
						</select>
						{{ __('screen-cart.mm') }} {{-- Edit BP_O2OQ-7 hainp 20200727 --}}
					{{-- Edit BP_O2OQ11 HUNGLM - 20200925 --}}
				</li>
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
			</ul>
		</div>
	</div>
</template>

<template v-if="Object.keys(colors_handle.data).length > 0">
	<div id="color-handle">
		<div class="option-group">
			<div><button class="btn c-btn large black c-label">{{ __('screen-select.color_handle') }}</button></div>
			<ul class="option color-list">
				<li v-for="(color, propertyName, index) in colors_handle.data" :key="propertyName">
					<a @click="selectColorHandle(color.m_color_id, color.color_name)" :m-color-id="color.m_color_id" :class="{'disabled': checkDisabledColorHandle == true}">
						<img :class="['color-img', {'active': color.m_color_id == colors_handle.id}]" :src="'/tostem/img/data/' + color.img_path + '/' + color.img_name">
					</a>
				</li>
			</ul>
		</div>
	</div>
</template>
