// Eclipse Euro Test
class BracQuest {
  public static void main(String[] args) {
    Brave b = new Brave();
    Map   m = new Map();
    m.setHuman(b);
    for ( int cnt=0; cnt<10; cnt++) {
      b.randomWalk();
    }
    
  }
}
