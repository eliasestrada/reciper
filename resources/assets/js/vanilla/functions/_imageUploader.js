// This object auto updates pictures after
// selecting them via file input
let imageUploader = {
	target: $("target-image"),
	src: $("src-image"),
	fr: new FileReader(),
	showImage: function () {
		this.src.addEventListener("change", ()=> {
			if (this.src.files.length !== 0) {
				var that = this
				this.fr.readAsDataURL(this.src.files[0])
				this.fr.onload = function(e) {
					that.target.src = this.result
				}
			} else {
				this.target.src = '/storage/images/default.jpg'
			}
		})
	}
}