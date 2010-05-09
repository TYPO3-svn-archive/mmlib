#<node0 attr0=val0>
#  <node1 attr1=val1 />
#  <node2 attr2=val2>
#    <node3 attr3=val3 />
#    <node4 attr4=val4 />
#  </node2>
#  <node3 attr3=val3 />
#  <node3 attr3=val3 />
#</node0>

10 = XML
10{
  src = <node0 attr0=val0>...</node0> # stdWrap
  renderObj.1 = COA
  renderObj.1{
     1 = TEXT
     1.field = attr0 # => val0
    10 = XML
    10.src.field = child:node1 # => <node1 attr1=val1 />
    10.renderObj.1 = TEXT
    10.renderObj.1.field = attr1 # => val1
    20 = XML
    20.src.field = child:node2 # => <node2 attr2=val2>...</node2>
    20.renderObj.1 = COA
    20.renderObj.1{
       2 = TEXT
       2.field = attr2 # => val2
      30 = XML
      30.src.field = child:node3 # => <node3 attr3=val3 />
      30.renderObj.1 = TEXT
      30.renderObj.1.field = attr3 # => val3
      40 = XML
      40.src.field = child:node4 # => <node4 attr4=val4 />
      40.renderObj.1 = TEXT
      40.renderObj.1.field = attr4 # => val4
    }
    30 = XML
    30.src.field = child:node3 # => <node3 attr3=val3 />\0<node3 attr3=val3 />
    30.renderObj{ # = .split
      token.char = 0
      cObjNum = 1
      # sort = attr3
      1 = COA      1.10 = XML
      1.10.src.current = 1 # => <node3 attr3=val3 />
      1.10.renderObj = TEXT
      1.10.renderObj.field = attr3 # => val3
    }
  }
}
