mmlib.xml = XML
mmlib.xml{
  src = FILE
  src.file = EXT:mmlib/dummy.xml
  renderObj = COA
  renderObj{
  
    10 = COA
    10{
      10 = TEXT
      10.field = this:name
      20 = TEXT
      20.field = name
      20.noTrimWrap = | name="|"|
      30 = TEXT
      30.field = alter
      30.noTrimWrap = | alter="|"|
      wrap = [|]<br/>
    }
    
    30 = TEXT
    30.field = child:sohn
    30.split {
      token.char = 0
      cObjNum = 1|*|2|*|3
      1{# = COA
        10 = XML
        10.src = TEXT
        10.src.current = 1
        10.renderObj < mmlib.xml.renderObj.10
        10.stdWrap.wrap = 1:|
      }
      2 < .1
      3.10.stdWrap.wrap = 2:|
      3 < .1
      3.10.stdWrap.wrap = 3:|
    }
    
    40 < .30
    40.field = child:tochter
    
  }
}

#mmlib.random = TEXT
#mmlib.random{
#  value = eins,zwei,drei
#  listNum.stdWrap.rand = 0|2
#}
