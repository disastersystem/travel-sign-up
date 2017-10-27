<template>
	<div class="box-card">
	    <div class="header">
	        <div class="title" v-text="'rom ' + room.num"></div>

	        <el-button type="default">
	            <!-- [+] legg til barneseng -->
	            +barneseng
	        </el-button>
	    </div>
	    <div class="text item">
	        <el-row>
	            <el-col :span="12">
	                <el-form-item label="navn">
	                    <el-input></el-input>
	                </el-form-item>
	            </el-col>

	            <el-col :span="12">
	                <el-form-item label="fødselsdato">
	                    <el-input></el-input>
	                </el-form-item>
	            </el-col>
	        </el-row>
	    </div>
	</div>
</template>

<script>
	export default {
		props: ['roomID']
	}
</script>

<style>
	.header {
		display: flex;
		align-items: stretch;
	}

	.title {
		flex: 1;
	}
</style>