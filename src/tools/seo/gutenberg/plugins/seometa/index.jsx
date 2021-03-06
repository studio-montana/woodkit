import { __ } from '@wordpress/i18n'
const { registerPlugin } = wp.plugins
const { Component, Fragment } = wp.element
const { withSelect, withDispatch } = wp.data
const { compose } = wp.compose
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost
const { PanelBody, PanelRow, TextControl } = wp.components
import WKG_Media_Selector from 'wkgcomponents/media-selector'
import WKG_Icons from 'wkgassets/icons'

registerPlugin('wkg-plugin-seometa', {
  icon: WKG_Icons.seo,
  render: (props) => {
    return (
      <Fragment>
          <PluginSidebarMoreMenuItem target="wkg-plugin-seometa">{__('Search engine optimisation', 'woodkit')}</PluginSidebarMoreMenuItem>
          <PluginSidebar name="wkg-plugin-seometa" title={__('Search engine optimisation', 'woodkit')} className="wkg-plugin-seometa">
              <PluginComponent />
          </PluginSidebar>
      </Fragment>
    )
  }
})

class PluginComponent_Base extends Component {
	constructor(props) {
		super(props)
	}
	render () {
		return (
			<Fragment>
				<PanelBody className="wkg-plugin-panelbody">
          <h4>{__('Search engines', 'woodkit')}</h4>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Title', 'woodkit')} value={this.props.meta_title} onChange={(value) => this.props.on_meta_change({'_seo_meta_title': value})} />
            <div className="wkg-info">{__('By default, publication title will be used.', 'woodkit')}</div>
          </PanelRow>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Description', 'woodkit')} value={this.props.meta_description} onChange={(value) => this.props.on_meta_change({'_seo_meta_description': value})} />
            <div className="wkg-info">{__('By default, publication excerpt will be used.', 'woodkit')}</div>
          </PanelRow>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Keywords', 'woodkit')} value={this.props.meta_keywords} onChange={(value) => this.props.on_meta_change({'_seo_meta_keywords': value})} />
            <div className="wkg-info">{__('Separate keywords by comma.', 'woodkit')}</div>
          </PanelRow>
				</PanelBody>
				<PanelBody className="wkg-plugin-panelbody">
          <h4>{__('Social networks', 'woodkit')}</h4>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Titre', 'woodkit')} value={this.props.meta_og_title} onChange={(value) => this.props.on_meta_change({'_seo_meta_og_title': value})} />
            <div className="wkg-info">{__('By default, title set for search engines will be used.', 'woodkit')}</div>
          </PanelRow>
          <PanelRow className="wkg-plugin-panelrow">
            <TextControl label={__('Description', 'woodkit')} value={this.props.meta_og_description} onChange={(value) => this.props.on_meta_change({'_seo_meta_og_description': value})} />
            <div className="wkg-info">{__('By default, description set for search engines will be used.', 'woodkit')}</div>
          </PanelRow>
          <PanelRow className="wkg-plugin-panelrow">
            <WKG_Media_Selector show label={__('Image', 'woodkit')} value={this.props.meta_og_image && this.props.meta_og_image !== 0 ? this.props.meta_og_image : null} onChange={(media) => this.props.on_meta_change({'_seo_meta_og_image': media && media.id ? media.id : 0})} />
            <div className="wkg-info">{__('By default, publication featured image will be used.', 'woodkit')}</div>
          </PanelRow>
				</PanelBody>
			</Fragment>
		)
	}
}

const applyWithSelect = withSelect(select => {
  let core_editor_store = select('core/editor')
  return {
    meta_title: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_title'],
    meta_description: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_description'],
    meta_keywords: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_keywords'],
    meta_og_title: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_og_title'],
    meta_og_description: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_og_description'],
    meta_og_image: core_editor_store.getEditedPostAttribute('meta')['_seo_meta_og_image'],
  }
})

const applyWithDispatch = withDispatch(dispatch => {
  let core_editor_store = dispatch('core/editor')
  return {
    on_meta_change: (meta) => {
      core_editor_store.editPost({meta})
    },
  }
})

const PluginComponent = compose(
    applyWithSelect,
    applyWithDispatch,
)(PluginComponent_Base)

const styles = {}
