import "../css/style.css"

// moduleフォルダ内のファイルでclass（どんなアクションを起こすかというオブジェクト）を設定し、エクスポートできるようにしておく→scriptsのファイルにclassをインポートする→constコマンドでclassを実行。同じクラス（オブジェクト）は繰り返し使える。//

// Our modules / classes
import MobileMenu from "./modules/MobileMenu"
import HeroSlider from "./modules/HeroSlider"
import GoogleMap from "./modules/GoogleMap"
import Search from "./modules/Search"
import MyMenu from "./modules/MyMenu"
import Like from "./modules/Like"

// Instantiate a new object using our modules/classes
const mobileMenu = new MobileMenu()
const heroSlider = new HeroSlider()
const googleMap = new GoogleMap()
const search = new Search()
const myMenu = new MyMenu()
const like = new Like()

// Allow new JS and CSS to load in browser without a traditional page refresh
if (module.hot) {
  module.hot.accept()
}
