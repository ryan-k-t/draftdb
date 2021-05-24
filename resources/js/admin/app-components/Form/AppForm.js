import { BaseForm } from 'craftable';

export default {
	mixins: [BaseForm],
	data: function(){
		return {
			datePickerConfig: {
				altInput: false,
				dateFormat: "Y-m-d"
			}
		}
	}
};