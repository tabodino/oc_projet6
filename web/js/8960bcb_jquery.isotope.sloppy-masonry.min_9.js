/*
 * Isotope custom layout mode that extends masonry in order to work with percentage-sized columns
 */

(function(l,e){e.extend(e.Isotope.prototype,{_sloppyMasonryReset:function(){var b=this.element.width(),d=this.options.sloppyMasonry&&this.options.sloppyMasonry.columnWidth||this.$filteredAtoms.outerWidth(!0)||b;this.sloppyMasonry={cols:Math.round(b/d),columnWidth:d};b=this.sloppyMasonry.cols;for(this.sloppyMasonry.colYs=[];b--;)this.sloppyMasonry.colYs.push(0)},_sloppyMasonryLayout:function(b){var d=this,c=d.sloppyMasonry;b.each(function(){var b=e(this),a=Math.round(b.outerWidth(!0)/c.columnWidth),
    a=Math.min(a,c.cols);if(1===a)d._sloppyMasonryPlaceBrick(b,c.colYs);else{var f=c.cols+1-a,h=[],k,g;for(g=0;g<f;g++)k=c.colYs.slice(g,g+a),h[g]=Math.max.apply(Math,k);d._sloppyMasonryPlaceBrick(b,h)}})},_sloppyMasonryPlaceBrick:function(b,d){for(var c=Math.min.apply(Math,d),e=0,a=0,f=d.length;a<f;a++)if(d[a]===c){e=a;break}this._pushPosition(b,this.sloppyMasonry.columnWidth*e,c);c+=b.outerHeight(!0);f=this.sloppyMasonry.cols+1-f;for(a=0;a<f;a++)this.sloppyMasonry.colYs[e+a]=c},_sloppyMasonryGetContainerSize:function(){return{height:Math.max.apply(Math,
    this.sloppyMasonry.colYs)}},_sloppyMasonryResizeChanged:function(){return!0}})})(this,this.jQuery);
