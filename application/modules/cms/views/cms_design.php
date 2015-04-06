<div class="n-abs-fit" ng-controller="CmsDesignController"
	 ng-init="restBaseUrl = '<?= base_url('/cms/rest/design') ?>'; refreshItems();">
	<div class="n-abs-fit uk-form n-sliding-panel" 
		 ng-class="{'n-on': currentView == 'list', 'n-off-prev': currentView == 'designer'}">
		<div class="n-options-header" 
			 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
			<div class="uk-grid uk-grid-collapse">
				<div class="uk-width-1-2">
					<button class="uk-button uk-button-success" ng-click="add()">
						<i class="uk-icon-plus"></i>
					</button>
				</div>
				<div class="uk-width-1-2 uk-text-right">
					<button class="uk-button">
						<i class="uk-icon-upload"></i> Import
					</button>
				</div>
			</div>
		</div>
		<div class="n-list">
			<div class="n-item-host uk-grid uk-grid-collapse">
				<div class="n-item uk-width-1-5" ng-repeat="item in items">
					<div class="uk-panel uk-panel-box" ng-cloak>
						{{item.name}}
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="n-design-editor n-abs-fit uk-form n-sliding-panel n-off-next"
		 ng-class="{'n-on': currentView == 'designer', 'n-off-next': currentView == 'list', 'n-expanded': fullScreen}">
		<div class="n-options-header" 
			 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
			<div class="uk-grid uk-grid-collapse">
				<div class="uk-width-2-3">
					<button class="uk-button n-tool-button" ng-click="toggle('fullScreen')"
							ng-class="{'uk-active': fullScreen}">
						<i class="uk-icon-expand" ng-if="!fullScreen"></i>
						<i class="uk-icon-compress" ng-if="fullScreen"></i>
					</button>

					<div class="uk-button-group">
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'edit-canvas'}"
								ng-click="switchToCanvasView()">
							<i class="uk-icon-th"></i>
						</button>
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'edit-code'}"
								ng-click="switchToCodeView()"
								ng-disabled="!designer.valid">
							<i class="uk-icon-code"></i>
						</button>
					</div>

					<div class="uk-button-group" 
						 ng-show="designerView == 'edit-canvas'">
						<button class="uk-button n-tool-button" style="width: auto"
								ng-class="{'uk-active': canvasView == 'large'}"
								ng-click="canvasView = 'large'">
							L
						</button>
						<button class="uk-button n-tool-button" style="width: auto"
								ng-class="{'uk-active': canvasView == 'medium'}"
								ng-click="canvasView = 'medium'">
							M
						</button>
						<button class="uk-button n-tool-button" style="width: auto"
								ng-class="{'uk-active': canvasView == 'small'}"
								ng-click="canvasView = 'small'">
							S
						</button>
					</div>

					<div class="uk-button-group" 
						 ng-show="designerView == 'edit-code'">
						<button class="uk-button n-tool-button" style="width: auto"
								ng-class="{'uk-active': codeView == 'html'}"
								ng-click="codeView = 'html'">
							HTML
						</button>
						<button class="uk-button n-tool-button" style="width: auto"
								ng-class="{'uk-active': codeView == 'js'}"
								ng-click="codeView = 'js'">
							JS
						</button>
						<button class="uk-button n-tool-button" style="width: auto"
								ng-class="{'uk-active': codeView == 'css'}"
								ng-click="codeView = 'css'">
							CSS
						</button>
					</div>

					<div class="uk-button-group">
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'preview-desktop'}"
								ng-click="designerView = 'preview-desktop'"
								ng-disabled="!designer.valid">
							<i class="uk-icon-desktop"></i>
						</button>
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'preview-tablet'}"
								ng-click="designerView = 'preview-tablet'"
								ng-disabled="!designer.valid">
							<i class="uk-icon-tablet"></i>
						</button>
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'preview-mobile'}"
								ng-click="designerView = 'preview-mobile'"
								ng-disabled="!designer.valid">
							<i class="uk-icon-mobile"></i>
						</button>
					</div>

					<div class="uk-button-group" 
						 ng-show="designerView == 'preview-tablet' || designerView == 'preview-mobile'">
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': !landscape}"
								ng-click="landscape = false">
							<i class="uk-icon-arrows-v"></i>
						</button>
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': landscape}"
								ng-click="landscape = true">
							<i class="uk-icon-arrows-h"></i>
						</button>
					</div>
				</div>
				<div class="uk-width-1-3 uk-text-right">
					<button class="uk-button uk-button-primary" 
							style="width: 80px"
							ng-disabled="!designer.valid">
						Save
					</button>
					<button class="uk-button" style="width: 80px" ng-click="cancel()">
						Cancel
					</button>
				</div>
			</div>
		</div>
		<div class="n-designer">
			<div class="n-abs-fit" ng-show="designerView == 'edit-canvas'">
				<div class="n-canvas-panel" 
					 ng-class="{'n-expanded': !componentExpanded}">
					<div class="n-inner-panel n-abs-fit n-overflow-auto"
						 ng-click="designer.clearActivePanel($event)"
						 ng-dblclick="designer.clearActivePanel($event); designer.showProperties();">
						<div class="n-layout-grid">
							<div gridster="designer.options">
								<ul>
									<li gridster-item="item" ng-repeat="item in designer.panels"
										ng-class="{
											'uk-active': item == designer.activePanel, 
											'n-height-fill': item.heightFactor == 'fill'
										}"
										ng-dblclick="designer.setActive(designer, item); designer.showProperties();">
										<div class="n-content">
										</div>
										<div class="n-indicators">
											<div class="ng-hide" ng-show="item.heightFactor == 'auto'">
												<i class="uk-icon-arrows-v"></i> auto
											</div>
											<div class="ng-hide" ng-show="item.heightFactor == 'fill'">
												<i class="uk-icon-arrows-v"></i> 100%
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="n-cover uk-text-center" ng-class="{'uk-active': designer.activePanel == null}">
						<div class="uk-alert uk-alert-danger uk-margin-top uk-display-inline-block ng-hide" 
							 ng-show="!designer.valid">
							<i class="uk-icon-exclamation-circle"></i> We do not support this kind of layout mixing.
						</div>
					</div>
				</div>
				<div class="n-components-panel" ng-class="{'n-collapsed': !componentExpanded}">
					<div class="uk-grid uk-grid-collapse" ng-hide="designer.activePanel != null">
						<div class="uk-width-1-6">
							<button class="uk-button uk-button-success n-tool-button"
									ng-click="designer.add(designer, 'panel')"
									title="Add New Panel"
									data-uk-tooltip="{pos:'left'}">
								<i class="uk-icon-plus"></i>
							</button>
							<button class="uk-button n-tool-button uk-margin-small-top"
									ng-click="designer.showProperties()"
									title="Body Properties"
									data-uk-tooltip="{pos:'left'}"
									ng-hide="componentExpanded">
								<i class="uk-icon-list-alt"></i>
							</button>
							<button class="uk-button n-tool-button ng-hide uk-margin-small-top"
									ng-click="designer.hideProperties()"
									title="Hide Properties"
									data-uk-tooltip="{pos:'left'}"
									ng-show="componentExpanded">
								<i class="uk-icon-toggle-right"></i>
							</button>
						</div>
						<div class="uk-width-5-6 ng-hide n-properties-panel" ng-show="componentExpanded">
							<div>
								<label for="canvas-css">Custom CSS</label>
								<div class="n-controls">
									<input id="canvas-css" type="text" class="uk-width-1-1" placeholder="CSS Class" 
										   ng-model="designer.css"/>
								</div>
							</div>

							<div>
								<label for="canvas-height">Height</label>
								<div class="n-controls">
									<select id="canvas-height" class="uk-width-1-1" 
											ng-model="designer.heightFactor">
										<option value="auto">By Content (height: auto)</option>
										<option value="fill">As Container (height: 100%)</option>
									</select>
								</div>
							</div>

							<div>
								<label for="canvas-columns">Columns</label>
								<div class="n-controls">
									<select id="canvas-columns" class="uk-width-1-1" 
											ng-model="designer.options.columns"
											ng-change="designer.determineEachRowAttributes()">
										<option value="10">10 Columns</option>
										<option value="12">12 Columns</option>
									</select>
								</div>
							</div>

						</div>
					</div>
					<div class="uk-grid uk-grid-collapse ng-hide" ng-show="designer.activePanel != null">
						<div class="uk-width-1-6">
							<button class="uk-button uk-button-success n-tool-button"
									ng-click="designer.add(designer, 'panel')"
									title="Add New Panel"
									data-uk-tooltip="{pos:'left'}">
								<i class="uk-icon-plus"></i>
							</button>
							<button class="uk-button n-tool-button uk-margin-small-top"
									ng-click="designer.showProperties()"
									title="Panel Properties"
									data-uk-tooltip="{pos:'left'}"
									ng-hide="componentExpanded">
								<i class="uk-icon-list-alt"></i>
							</button>
							<button class="uk-button n-tool-button ng-hide uk-margin-small-top"
									ng-click="designer.hideProperties()"
									title="Hide Properties"
									data-uk-tooltip="{pos:'left'}"
									ng-show="componentExpanded">
								<i class="uk-icon-toggle-right"></i>
							</button>
							<div>
								<button class="uk-button n-tool-button uk-margin-small-top"
										ng-click="designer.drillDown(designer.activePanel)"
										title="Drill Down"
										data-uk-tooltip="{pos:'left'}"
										ng-show="designer.activePanel.type == 'container'">
									<i class="uk-icon-level-down"></i>
								</button>
							</div>
							<button class="uk-button uk-button-danger n-tool-button uk-margin-small-top"
									ng-click="designer.delete(designer, designer.activePanel)"
									title="Remove Panel"
									data-uk-tooltip="{pos:'left'}">
								<i class="uk-icon-trash"></i>
							</button>
						</div>
						<div class="uk-width-5-6 ng-hide n-properties-panel" ng-show="componentExpanded">
							<div>
								<label for="css">Custom CSS</label>
								<div class="n-controls">
									<input id="css" type="text" class="uk-width-1-1" placeholder="CSS Class" 
										   ng-model="designer.activePanel.css"/>
								</div>
							</div>

							<div>
								<label for="height">Height</label>
								<div class="n-controls">
									<select id="height" class="uk-width-1-1" 
											ng-model="designer.activePanel.heightFactor"
											ng-change="designer.panelHeightFactorChanged()">
										<option value="grid">
											As Grid Cell (height: 
											{{designer.activePanel.sizeY * designer.options.rowHeight}}px)
										</option>
										<option value="auto">By Content (height: auto)</option>
										<option value="fill">As Container (height: 100%)</option>
									</select>
								</div>
							</div>

							<div>
								<label for="width">Width</label>
								<div class="n-controls">
									<select id="width" class="uk-width-1-1" 
											ng-model="designer.activePanel.sizeX">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11" ng-show="designer.options.columns == 12">11</option>
										<option value="12" ng-show="designer.options.columns == 12">12</option>
									</select>
								</div>
							</div>

							<div>
								<label for="type">Panel Type</label>
								<div class="n-controls">
									<select id="type" class="uk-width-1-1"
											ng-model="designer.activePanel.type">
										<option value="container">Layout Container</option>
										<option value="content">Mixed Content</option>
										<option value="nav">Navigation</option>
										<!-- Not for this editor
										<option value="slide">Slide View</option>
										<option value="ads">Ads</option>
										<option value="items">Items List</option>
										-->
										<option value="placeholder">Placeholder</option>
									</select>
								</div>
							</div>

							<div class="ng-hide" ng-show="designer.activePanel.type == 'nav'">
								<label for="levels">Navigation Levels</label>
								<div class="n-controls">
									<select id="levels" class="uk-width-1-1"
											ng-model="designer.activePanel.nav.levels">
										<option value="1">1</option>
										<option value="2">1-2</option>
										<option value="3">1-3</option>
										<option value="all">All Levels</option>
									</select>
								</div>
							</div>

							<div class="ng-hide" ng-show="designer.activePanel.type == 'slide'">
								<label for="transition">Transition</label>
								<div class="n-controls">
									<select id="transition" class="uk-width-1-1"
											ng-model="designer.activePanel.slide.transition">
										<option value="fade">Fade</option>
										<option value="scroll">Scroll</option>
										<option value="scale">Scale</option>
										<option value="swipe">Swipe</option>
										<option value="slice-down">Slice Down</option>
										<option value="slice-up">Slice Up</option>
										<option value="slice-up-down">Slice Up Down</option>
										<option value="fold">Fold</option>
										<option value="puzzle">Puzzle</option>
										<option value="boxes">Boxes</option>
										<option value="boxes-reverse">Boxes Reverse</option>
										<option value="random">Random</option>
									</select>
								</div>

								<div class="ng-hide" 
									 ng-show="designer.activePanel.slide.transition.indexOf('slice') == 0">

									<label for="slices">Slices</label>
									<div class="n-controls">
										<select id="slices" class="uk-width-1-1"
												ng-model="designer.activePanel.slide.slices">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
										</select>
									</div>
								</div>

								<label for="ken-burns">Ken Burns Effect</label>
								<div class="n-controls">
									<select id="ken-burns" class="uk-width-1-1"
											ng-model="designer.activePanel.slide.kenburns">
										<option value="false">No</option>
										<option value="true">Yes</option>
									</select>
								</div>

								<label for="duration">Duration</label>
								<div class="n-controls">
									<input id="duration" class="uk-width-1-1"
										   ng-model="designer.activePanel.slide.duration"/>
								</div>

								<label for="auto-play">Auto Play</label>
								<div class="n-controls">
									<select id="auto-play" class="uk-width-1-1"
											ng-model="designer.activePanel.slide.autoplay">
										<option value="false">No</option>
										<option value="true">Yes</option>
									</select>
								</div>

								<label for="auto-play-interval">Auto Play Interval</label>
								<div class="n-controls">
									<input id="auto-play-interval" class="uk-width-1-1"
										   ng-model="designer.activePanel.slide.autoplayInterval"/>
								</div>

								<label for="video-auto-play">Video Auto Play</label>
								<div class="n-controls">
									<select id="video-auto-play" class="uk-width-1-1"
											ng-model="designer.activePanel.slide.videoautoplay">
										<option value="false">No</option>
										<option value="true">Yes</option>
									</select>
								</div>

								<label for="video-mute">Video Mute</label>
								<div class="n-controls">
									<select id="video-mute" class="uk-width-1-1"
											ng-model="designer.activePanel.slide.videomute">
										<option value="false">No</option>
										<option value="true">Yes</option>
									</select>
								</div>
							</div>

							<div class="ng-hide" ng-show="designer.activePanel.type == 'ads'">
							</div>

							<div class="ng-hide" ng-show="designer.activePanel.type == 'items'">
								<label for="items-layout">List Layout</label>
								<div class="n-controls">
									<select id="video-auto-play" class="uk-width-1-1"
											ng-model="designer.activePanel.items.layout">
										<option value="basic">Basic</option>
										<option value="table">Table</option>
										<option value="grid">Grid</option>
										<option value="bricks">Masonry Bricks</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="n-abs-fit n-overflow-auto" ng-show="designerView == 'preview-desktop'">

			</div>
			<div class="n-abs-fit n-overflow-auto" ng-show="designerView == 'preview-tablet'">
				<div class="n-tablet-preview n-device-preview" ng-class="{'n-landscape': landscape}">
				</div>
			</div>
			<div class="n-abs-fit n-overflow-auto" ng-show="designerView == 'preview-mobile'">
				<div class="n-mobile-preview n-device-preview" ng-class="{'n-landscape': landscape}">
				</div>
			</div>
			<div class="n-abs-fit n-overflow-auto" ng-show="designerView == 'edit-code'">
				<div ng-show="codeView == 'html'" 
					 ui-codemirror="{ lineNumbers: true, theme: 'zenburn', mode: 'htmlmixed' }" 
					 ng-model="designer.html"
					 ui-refresh="designer.refreshEditor"></div>

				<div ng-show="codeView == 'js'" 
					 ui-codemirror="{ lineNumbers: true, theme: 'zenburn', mode: 'javascript' }" 
					 ng-model="designer.javascript"></div>

				<div ng-show="codeView == 'css'" 
					 ui-codemirror="{ lineNumbers: true, theme: 'zenburn', mode: 'css' }" 
					 ng-model="designer.css"></div>
			</div>
		</div>
	</div>
</div>